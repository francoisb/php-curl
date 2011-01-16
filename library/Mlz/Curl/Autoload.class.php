<?php

/**
 * Autoload class.
 *
 * @category    MLZ
 * @package     Mlz_Curl
 * @subpackage  Autoload
 * @author      François Béliveau  <francois.beliveau@my-labz.com>
 */
class Mlz_Curl_Autoload
{
    static protected
        $registered = false,
        $externals  = array('mlz-php-option' => 'Mlz_Option');

    /**
     * Register mlzCurlAutoload in spl autoloader.
     */
    static public function register()
    {
        if (self::$registered)
        {
            return;
        }

        ini_set('unserialize_callback_func', 'spl_autoload_call');
        if (false === spl_autoload_register(array(__CLASS__, 'autoload')))
        {
            throw new Exception(sprintf('Unable to register %s::autoload as an autoloading method.', __CLASS__));
        }

        self::$registered = true;
    }

    /**
     * Unregister mlzCurlAutoload from spl autoloader.
     */
    static public function unregister()
    {
        spl_autoload_unregister(array(__CLASS__, 'autoload'));
        self::$registered = false;
    }

    /**
     * Handles autoloading of classes.
     *
     * @param  string           $class A class name.
     * @return boolean          Returns true if the class has been loaded
     */
    static public function autoload($class)
    {
        // class already exists
        if (class_exists($class, false) || interface_exists($class, false))
        {
            return true;
        }

        $basePath  = realpath(dirname(__file__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..');
        $classPath = str_replace('_', DIRECTORY_SEPARATOR, $class).'.class.php';
        $file      = $basePath.DIRECTORY_SEPARATOR.'library'.DIRECTORY_SEPARATOR.$classPath;

        if (is_file($file))
        {
            require $file;
            return true;
        }

        // Check if it's an external class
        $basePath .= DIRECTORY_SEPARATOR.'externals';
        foreach (self::$externals as $dir => $prefix)
        {
            $file = $basePath.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.'library'.DIRECTORY_SEPARATOR.$classPath;
            if (is_file($file))
            {
                require $file;
                return true;
            }
        }

        return false;
    }
}
