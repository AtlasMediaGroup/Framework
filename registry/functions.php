<?php
/**
 * Caldera Community Framework
 *
 * @version 1.0.0
 * @copyright 2015 Caldera Community Framework
 * @authors Matt Kent, Dan Jones
 */

namespace CCF\Registry\Additions;

define('DS', DIRECTORY_SEPARATOR); // @TODO move to better location

function registryStoreObjectPath($object)
{
    $dir = 'objects';

    if (strpos($object, '.class.php') !== false) {
        str_replace('.class.php', '', $object);
    }

    if (strpos($object, '/') === false) {
        require_once $dir . DS . $object . '.class.php';
        return;
    }

    if (file_exists($dir . DS . $object) AND is_dir($dir . DS . $object)) {
        require_once $dir . DS . $object . '.class.php';
    } else {
        trigger_error('Unknown object location: ' . $object);
    }
}

function getFuncArgNames($function)
{
    $func = new \ReflectionFunction($function);
    $result = array();
    foreach ($func->getParameters() as $param) {
        $result[] = $param->name;
    }
    return $result;
}