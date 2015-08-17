<?php
/**
 * Caldera Community Framework
 *
 * @version 1.0.0
 * @copyright 2015 Caldera Community Framework
 * @authors Matt Kent, Dan Jones
 */
// @TODO remove version checks
// @TODO Set config options for session paths etc
// @TODO Change md5 to better algorithm in fingerprint method!

// Yeah, really do need to apply these changes but seriously cannot be arsed,
// like it needs doing, but there's just so fucking many "todos" and, let's be honest
// when is that actually going to get done...probably never!
namespace CCF\Registry\Objects\Session;

use CCF\Registry\Additions as Functions;

class SecureSessionHandler extends \SessionHandler
{
    protected $key, $name, $cookie;

    public function __construct($key, $name = 'MY_SESSION', $cookie = array())
    {
        $this->key = $key;
        $this->name = $name;
        $this->cookie = $cookie;

        $this->cookie += [
            'lifetime' => 0,
            'path'     => ini_get('session.cookie_path'),
            'domain'   => ini_get('session.cookie_domain'),
            'secure'   => isset($_SERVER['HTTPS']),
            'httponly' => true // @TODO config option (default to true)
        ];

        $this->setup();
    }

    private function setup()
    {
        ini_set('session.use_cookies', 1); // @TODO Make a config option
        ini_set('session.use_only_cookies', 1); // @TODO Make a config option

        session_name($this->name);

        session_set_cookie_params(
            $this->cookie['lifetime'],
            $this->cookie['path'],
            $this->cookie['domain'],
            $this->cookie['secure'],
            $this->cookie['httponly']
        );
    }

    public function start()
    {
        if (php_sapi_name() !== 'cli') {
            if (version_compare(phpversion(), '5.4.0', '>=')) {
                if (session_status() === PHP_SESSION_ACTIVE) {
                    if (session_start()) {
                        return mt_rand(0, 4) === 0 ? $this->regenerate() : true;
                    }
                }
            } else {
                if (session_id() === '') {
                    if (session_start()) {
                        return mt_rand(0, 4) === 0 ? $this->regenerate() : true;
                    }
                }
            }
        }

        return false;
    }

    public function extinguish()
    {
        if (php_sapi_name() !== 'cli') {
            if (version_compare(phpversion(), '5.4.0', '>=')) {
                if (session_status() === PHP_SESSION_DISABLED) {
                    return false;
                }
            } else {
                if (session_id() === '') {
                    return false;
                }
            }
        }

        $_SESSION = [];
        setcookie(
            $this->name,
            '',
            time() - 42000,
            $this->cookie['path'],
            $this->cookie['domain'],
            $this->cookie['secure'],
            $this->cookie['httponly']
        );

        return session_destroy();
    }

    public function regenerate()
    {
        return session_regenerate_id(true);
    }

    public function read($id)
    {
        return mcrypt_decrypt(MCRYPT_3DES, $this->key, parent::read($id), MCRYPT_MODE_ECB);
    }

    public function write($id, $data)
    {
        return parent::write($id, mcrypt_encrypt(MCRYPT_3DES, $this->key, $data, MCRYPT_MODE_ECB));
    }

    public function isExpired($ttl = 30)
    {
        $last = isset($_SESSION['_last_activity']) ? $_SESSION['_last_activity'] : false;

        if ($last !== false AND time() - $last > $ttl * 60) {
            return true;
        }

        $_SESSION['_last_activity'] = time();

        return false;
    }

    public function isFingerprint() //@TODO Remove MD5
    {
        $hash = md5($_SERVER['HTTP_USER_AGENT'] . ip2long($_SERVER['REMOTE_ADDR']) & ip2long('255.255.0.0'));

        if (isset($_SESSION['_fingerprint'])) {
            return $_SESSION['_fingerprint'] === $hash;
        }

        $_SESSION['_fingerprint'] = $hash;

        return true;
    }

    public function isValid($ttl = 30)
    {
        if (!is_int($ttl) OR !is_numeric($ttl)) {
            trigger_error('Parameter (' . Functions\getFuncArgNames($this->isValid()) . '): '
                . func_get_arg(0) . ' must be of type integer.');
        } else {
            return !$this->isExpired($ttl) AND $this->isFingerprint();
        }
    }

    public function get($key)
    {
        $parsed = explode('.', $key);
        $result = $_SESSION;

        while ($parsed) {
            $next = array_shift($parsed);

            if (isset($result[$next])) {
                $result = $result[$next];
            } else {
                return null;
            }
        }

        return $result;
    }

    public function set($key, $value)
    {
        $parsed = explode('.', $key);
        $session =& $_SESSION;

        while (count($parsed) > 1) {
            $next = array_shift($parsed);

            if (!isset($session[$next]) OR !is_array($session[$next])) {
                $session[$next] = [];
            }
            $session =& $session[$next];
        }

        $session[array_shift($parsed)] = $value;
    }

    public function setSaveHandler($session, $close = null)
    {
        if (is_null($close) OR !is_bool($close)) {
            trigger_error('Second Argument must be of type boolean. ' . gettype($close) . ' given.');
        } else {
            session_set_save_handler($session, $close);
            return true;
        }
    }

    /**
     * @param string $path
     * @return bool
     * Will attempt to make dir if doesn't already exist,
     * defaults to __DIR__ . '/sessions/' for enhanced
     * security.
     * @throws \Exception
     */
    public function savePath($path = __DIR__ . '/sessions/')
    {
        $path = rtrim($path, '/') . '/';
        if (!is_dir($path) OR !file_exists($path)) {
            try {
                mkdir($path);
            } catch (\Exception $e) {
                $error = 'Error Creating path: ' . $path . '<br /><br />';
                $error .= 'Code: ' .            $e->getCode() .          '<br />';
                $error .= 'Message: ' .         $e->getMessage() .       '<br />';
                $error .= 'File: ' .            $e->getFile() .          '<br />';
                $error .= 'Line: ' .            $e->getLine() .          '<br />';
                $error .= 'Trace: ' .           $e->getTrace() .         '<br />';
                $error .= 'Trace as string: ' . $e->getTraceAsString() . '<br />';

                throw new \Exception($error);
            }
        } else {
            session_save_path($path);
            return true;
        }
    }
}

$session = new SecureSessionHandler('cheese');
ini_set('session.save_handler', 'files');
//session_set_save_handler($session, true);
$session->setSaveHandler($session, true);
//session_save_path(__DIR__ . '/sessions');
$session->savePath(); // Defaults to __DIR__ . '/sessions/'

$session->start();

if (!$session->isValid(5)) {
    $session->extinguish();
}

$session->set('hello.world', 'bonjour');
echo $session->get('hello.world');