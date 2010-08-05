<?php

/**
 * Response header class.
 *
 * @category    MLZ
 * @package     Mlz_Curl
 * @subpackage  Response
 * @author      François Béliveau  <francois.beliveau@my-labz.com>
 */
class Mlz_Curl_Response_Header extends Mlz_Curl_Response_Infos
{
    /**
     * Constructor.
     *
     * @param  array $contents
     */
    public function __construct()
    {
        parent::__construct(array());
    }

    /**
     * Initialize object.
     *
     * @param  ressource $curlHandler
     * @param  string $headerContent
     * @return integer
     */
    public function initialize($curlHandler, $headerContent)
    {
        $key     = null;
        $content = $headerContent;
        $pos     = strpos($content, ':');

        if (false !== $pos)
        {
            $contents = explode(':', $content, 2);
            $key      = trim($contents[0]);
            $content  = trim($contents[1]);
        }

        $this->set($content, $key);

        return strlen($headerContent);
    }
  
    /**
     * Return a normalized content key.
     *
     * @param  string $key
     * @return string
     */
    protected function normalizeContentKey($key)
    {
        return preg_replace('/\-(.)/e', "'-'.strtoupper('\\1')", strtr(ucfirst(strtolower($key)), '_', '-'));
    }
}
