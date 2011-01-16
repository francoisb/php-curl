<?php

/**
 * Request class.
 *
 * @category    MLZ
 * @package     Mlz_Curl
 * @subpackage  Request
 * @author      François Béliveau  <francois.beliveau@my-labz.com>
 * @see         http://www.php.net/manual/en/book.curl.php
 */
class Mlz_Curl_Request extends Mlz_Option
{
    protected
        $curlOptions = array();

    /**
     * Constructor.
     *
     * @param   array $options (optional)
     * @param   array $options (optional)
     * @see     http://php.net/manual/en/curl.constants.php
     */
    public function __construct(array $options = array(), array $curlOptions = array())
    {
        parent::__construct($options);
        $this->setCurlOptions($curlOptions);
    }

    /**
     * Set curl options.
     *
     * @param   array $options
     * @see     http://php.net/manual/en/curl.constants.php
     */
     public function setCurlOptions(array $options)
     {
         foreach ($options as $key => $value)
         {
             $this->setCurlOption($key, $value);
         }
     }

    /**
     * Set curl option.
     *
     * @param   string $key
     * @param   mixed $value
     * @see     http://php.net/manual/en/curl.constants.php
     */
     public function setCurlOption($key, $value)
     {
         $this->curlOptions[(string)$key] = $value;
     }

    /**
     * Has curl option.
     *
     * @param   string $key
     * @return  boolean
     */
    public function hasCurlOption($key)
    {
        return array_key_exists($key, $this->curlOptions);
    }

    /**
     * Get curl options.
     *
     * @return  array
     */
    public function getCurlOptions()
    {
        return $this->curlOptions;
    }

    /**
     * Get curl option.
     *
     * @param   string $key
     * @param   mixed $default
     * @return  mixed
     */
    public function getCurlOption($key, $default = null)
    {
        return $this->hasCurlOption($key) ? $this->curlOptions[$key] : $default;
    }

    /**
     * Execute request
     *
     * @return  mlzCurlResponse
     */
    public function execute()
    {
        $curlHandler = $this->createCurlHandler();

        $this->beforeExecute($curlHandler);

        try
        {
            $curlResponseHeader = $this->createCurlResponseHeader($curlHandler);
            $responseContent    = $this->doExecute($curlHandler);
            $curlResponseinfos  = $this->createCurlResponseInfos($curlHandler);
        }
        catch(Exception $e)
        {
            $this->afterExecute($curlHandler);
            throw $e;
        }

        $this->afterExecute($curlHandler);

        return $this->createCurlResponse($responseContent, $curlResponseHeader, $curlResponseinfos);
    }

    /**
     * Create and initialize a response.
     *
     * @param   string $responseContent
     * @param   Mlz_Curl_Response_Header $curlResponseHeader
     * @param   Mlz_Curl_Response_Infos $curlResponseInfos
     * @return  mlzCurlResponse
     */
    protected function createCurlResponse($responseContent, Mlz_Curl_Response_Header $curlResponseHeader, Mlz_Curl_Response_Infos $curlResponseInfos)
    {
        $classname = $this->getOption('response_classname', 'Mlz_Curl_Response');

        return new $classname($responseContent, $curlResponseHeader, $curlResponseInfos);
    }

    /**
     * Create a curl response header.
     *
     * @param   resource $curlHandler
     * @return  Mlz_Curl_Response_Header
     */
    protected function createCurlResponseHeader($curlHandler)
    {
        $classname = $this->getOption('response_header_classname', 'Mlz_Curl_Response_Header');
        $header    = new $classname();

        curl_setopt($curlHandler, CURLOPT_HEADERFUNCTION, array($curlResponseHeader, 'initialize'));

        return $header;
    }

    /**
     * Create a curl response header.
     *
     * @param   resource $curlHandler
     * @return  Mlz_Curl_Response_Infos
     */
    protected function createCurlResponseInfos($curlHandler)
    {
        $content   = curl_getinfo($curlHandler);
        $classname = $this->getOption('response_infos_classname', 'Mlz_Curl_Response_Infos');
        $infos     = new $classname($contents);

        return $infos;
    }

    /**
     * Create a curl handler and initialize it.
     *
     * @return  ressource
     */
    protected function createCurlHandler()
    {
        if (!extension_loaded('curl'))
        {
            throw new Mlz_Curl_Exception(sprintf('"%s" extension not loaded.', 'curl'));
        }

        $curlHandler = curl_init($this->fixUrl($this->getRequiredOption('url')));
        foreach ($this->getCurlOptions() as $key => $value)
        {
            curl_setopt($curlHandler, $key, $value);
        }

        return $curlHandler;
    }

    /**
     * Exeucte the request and return the content.
     *
     * @param   resource $curlHandler
     * @return  string
     * @throws  Mlz_Curl_Exception
     */
    protected function doExecute($curlHandler)
    {
        $result = curl_exec($curlHandler);
        if (curl_errno($curlHandler))
        {
            if ($this->hasOption('logger'))
            {
                $logger->stop();
            }
            throw new Mlz_Curl_Exception(curl_error($curlHandler));
        }

        return $result;
    }

    /**
     * Do stuff before execute request.
     *
     * @param   resource $curlHandler
     */
    protected function beforeExecute($curlHandler)
    {
        if ($this->hasOption('logger'))
        {
            $logger = $this->getOption('logger');
            if (!$logger instanceof Mlz_Curl_Logger)
            {
                throw new InvalidArgumentException(sprintf('Logger option is not an instance of "%s"', 'Mlz_Curl_Logger'));
            }

            $logger->start();
            curl_setopt($curlHandler, CURLOPT_STDERR, $logger->getFileHandler());
            curl_setopt($curlHandler, CURLOPT_VERBOSE, true);
        }
    }

    /**
     * Do stuff after execute request.
     *
     * @param   resource $curlHandler
     */
    protected function afterExecute($curlHandler)
    {
        curl_close($curlHandler);
        if ($this->hasOption('logger'))
        {
            $this->getOption('logger')->stop();
        }
    }

    /**
     * Fix an url.
     *
     * @param   string $url
     * @return  string
     */
    protected function fixUrl($url)
    {
        if ($this->getOption('fix_url'))
        {
            if ('/' != substr($url, strlen($url)-1))
            {
                $url .= '/';
            }
        }

        return $url;
    }
}
