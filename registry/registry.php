<?php
/**
 * Caldera Community Framework
 *
 * @version 1.0.0
 * @copyright 2015 Caldera Community Framework
 * @authors Matt Kent, Dan Jones
 */

namespace CCF\Registry;

use CCF\Registry\Additions as Functions;

class Registry
{

    /**
     * Our array of objects
     * @access private
     */
    private static $objects = array();

    /**
     * Our array of settings
     * @access private
     */
    private static $settings = array();

    /**
     * The framework's human readable name & version
     */
    const FRAMEWORK_NAME = 'Caldera Community Framework';

    const FRAMEWORK_VERSION = '1.0.0';

    /**
     * The instance of the registry
     * @access private
     */
    private static $instance;

    /**
     * Private constructor to prevent it being created directly
     * @access private
     */
    private function __construct() {}

    /**
     * singleton method used to access the object
     * @access public
     */
    public static function instance()
    {
        if (!isset(self::$instance) OR !(self::$instance instanceof self)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * prevent cloning of the object: issues an E_USER_ERROR if this is attempted
     */
    public function __clone()
    {
        trigger_error('Cloning the registry is not permitted', E_USER_ERROR);
    }

    /**
     * Stores an object in the registry
     * @param String $object the name of the object
     * @param String $key the key for the array
     * @return void
     * @TODO Clean up, set directory to class var/const
     */
    public function storeObject($object, $key)
    {
        Functions\registryStoreObjectPath($object);
        self::$objects[$key] = new $object(self::$instance);
    }

    /**
     * Gets an object from the registry
     * @param String $key the array key
     * @return object
     */
    public function getObject($key)
    {
        if (is_object(self::$objects[$key])) {
            return self::$objects[$key];
        }
    }

    /**
     * Stores settings in the registry
     * @param String $data
     * @param String $key the key for the array
     * @return void
     */
    public function storeSetting($data, $key)
    {
        self::$settings[$key] = $data;
    }

    /**
     * Gets a setting from the registry
     * @param String $key the key in the array
     */
    public function getSetting($key)
    {
        return self::$settings[$key];
    }

    /**
     * Gets the framework's name
     * @return String
     */
    public function getFrameworkName()
    {
        return self::FRAMEWORK_NAME;
    }

    public function storeCoreObjects()
    {
        $this->storeObject('database/database', 'db');
        $this->storeObject('template/template', 'template');
    }


}