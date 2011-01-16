<?php

/**
 * Mock request class.
 *
 * @category    MLZ
 * @package     Mlz_Curl
 * @subpackage  Request
 * @author      François Béliveau  <francois.beliveau@my-labz.com>
 */
class Mlz_Curl_RequestMock extends Mlz_Curl_Request
{
    /**
     * Create a curl response header.
     *
     * @param   resource        $curlHandler
     * @return  Mlz_Curl_Response_Header
     */
    protected function createCurlResponseHeader($curlHandler)
    {
        return $this->getOption('response_headers_mock', new Mlz_Curl_Response_Header());
    }

    /**
     * Create a curl response header.
     *
     * @param   resource        $curlHandler
     * @return  Mlz_Curl_Response_Infos
     */
    protected function createCurlResponseInfos($curlHandler)
    {
        return $this->getOption('response_infos_mock', new Mlz_Curl_Response_Infos(array()));
    }

    /**
     * Create a curl handler and initialize it.
     *
     * @return  ressource
     */
    protected function createCurlHandler()
    {
        return null;
    }

    /**
     * Exeucte the request and return the content.
     *
     * @param   resource        $curlHandler
     * @return  string
     * @throws  Mlz_Curl_Exception
     */
    protected function doExecute($curlHandler)
    {
        return $this->getRequiredOption('response_mock');
    }

    /**
     * Do stuff before execute request.
     *
     * @param   resource        $curlHandler
     */
    protected function beforeExecute($curlHandler)
    {
        // nothing
    }

    /**
     * Do stuff after execute request.
     *
     * @param   resource        $curlHandler
     */
    protected function afterExecute($curlHandler)
    {
        // nothing
    }
}
