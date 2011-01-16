<?php

/**
 * Request factory class.
 *
 * @category    MLZ
 * @package     Mlz_Curl
 * @subpackage  Request
 * @author      François Béliveau  <francois.beliveau@my-labz.com>
 */
class Mlz_Curl_Request_Factory
{
    static protected
        $prefix             = '',
        $suffix             = '',
        $defaultOptions     = array(),
        $defaultCurlOptions = array();

    /**
     * Create a new request.
     *
     * @param  array            $curlOptions (optional)
     * @param  array            $options (optional)
     * @param  string           $classname (optional)
     * @return mlzCurlRequest
     */
    static public function create(array $curlOptions = array(), array $options = array(), $classname =  null)
    {
        if (is_null($classname))
        {
            $classname = 'Mlz_Curl_Request';
        }
        $classname = self::getPrefix().$classname.self::getSuffix();

        if (!class_exists($classname))
        {
            throw new InvalidArgumentException(sprintf('Class "%s" not exists.', $classname));
        }

        $request = new $classname();
        if (!$request instanceof Mlz_Curl_Request)
        {
            throw new InvalidArgumentException(sprintf('The request object is not an instance of "%s".', 'Mlz_Curl_Request'));
        }

        $request->setCurlOptions(array_merge(self::getDefaultCurlOptions(), $curlOptions));
        $request->setOptions(array_merge(self::getDefaultOptions(), $options));

        return $request;
    }

    /**
     * Set the common defaults options.
     *
     * @param  array            $options
     */
    static public function setDefaultOptions(array $options)
    {
        self::$defaultOptions = $options;
    }

    /**
     * Get the common defaults options.
     *
     * @return array
     */
    static public function getDefaultOptions()
    {
        return self::$defaultOptions;
    }
  
    /**
     * Set the common defaults CURL options.
     *
     * @param  array            $options
     */
    static public function setDefaultCurlOptions(array $options)
    {
        self::$defaultCurlOptions = $options;
    }

    /**
     * Get the common defaults CURL options.
     *
     * @return array
     */
    static public function getDefaultCurlOptions()
    {
      return self::$defaultCurlOptions;
    }

    /**
     * Set the classname prefix.
     *
     * @param  string       $prefix
     */
    static public function setPrefix($prefix)
    {
      self::$prefix = (string)$prefix;
    }

    /**
     * Get the defined classname prefix.
     *
     * @return string
     */
    static public function getPrefix()
    {
      return self::$prefix;
    }
    
    /**
     * Set the classname prefix.
     *
     * @param  string           $sufix
     */
    static public function setSuffix($suffix)
    {
        self::$suffix = (string)$suffix;
    }

    /**
     * Get the defined classname suffix.
     *
     * @return string
     */
    static public function getSuffix()
    {
        return self::$suffix;
    }
}
