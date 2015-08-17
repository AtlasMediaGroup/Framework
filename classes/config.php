<?php
/**
 * Caldera Community Framework
 *
 * @version 1.0.0
 * @copyright 2015 Caldera Community Framework
 * @authors Matt Kent, Dan Jones
 */

namespace CCF\Classes;

class Config
{
    public static $config; // Public allows for better unit tests.

    public static function get($key)
    {
        if (!self::$config) {
            foreach (scandir('../config') as $handle) {
                $path = '../config/' . $handle;
                if (is_file($path) AND file_exists($path)) {
                    require $path;
                } else {
                    trigger_error('Error requiring config path: ' . $path, E_USER_ERROR);
                }
            }
        }
    }
}