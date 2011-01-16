<?php

/**
 * HTTP request factory class.
 *
 * @category    MLZ
 * @package     Mlz_Curl
 * @subpackage  Request
 * @author      François Béliveau  <francois.beliveau@my-labz.com>
 */
class Mlz_Curl_Request_Factory_Http
{
    /**
     * Create a new HTTP request using GET method.
     *
     * @param  array            $curlOptions (optional)
     * @param  array            $options (optional)
     * @param  string           $classname (optional)
     * @return mlzCurlRequest
     */
    static public function createGet(array $curlOptions = array(), array $options = array(), $classname = null)
    {
        $curlOptions[CURLOPT_RETURNTRANSFER] = true;
        $curlOptions[CURLOPT_CUSTOMREQUEST]  = 'GET';

        return Mlz_Curl_Request_Factory::create($curlOptions, $options, $classname);
    }

    /**
     * Create a new HTTP request using POST method.
     *
     * @param  array            $data An associative array of data to send.
     * @param  array            $curlOptions (optional)
     * @param  array            $options (optional)
     * @param  string           $classname (optional)
     * @return mlzCurlRequest
     */
    static public function createPost(array $postData, array $curlOptions = array(), array $options = array(), $classname = null)
    {
        $curlOptions[CURLOPT_RETURNTRANSFER] = true;
        $curlOptions[CURLOPT_POST]           = 'POST';
        $curlOptions[CURLOPT_POSTFIELDS]     = $postData; 

        return Mlz_Curl_Request_Factory::create($curlOptions, $options, $classname);
    }
}
