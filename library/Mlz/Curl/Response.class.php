<?php

/**
 * Curl response class.
 *
 * @category        MLZ
 * @package         Mlz_Curl
 * @subpackage      Response
 * @author          François Béliveau  <francois.beliveau@my-labz.com>
 */
class Mlz_Curl_Response
{
    protected
        $header  = null,
        $infos   = null,
        $content = '';

    /**
     * Constructor.
     *
     * @param   string          $content
     * @param   Mlz_Curl_Response_Header $header
     * @param   mlz_Curl_Response_Infos $infos
     */
    public function __construct($content, Mlz_Curl_Response_Header $header, mlz_Curl_Response_Infos $infos)
    {
        $this->content = (string)$content;
        $this->header  = $header;
        $this->infos   = $infos;
    }

    /**
     * Return whether the response code match an error one.
     *
     * @return  boolean
     */
    public function isError()
    {
        $code = $this->getInfos() ? $this->getInfos()->get('http_code', 0) : 0;
        return in_array((int)($code / 100), array(4, 5));
    }

    /**
     * Return whether the content is encoded or not.
     *
     * @return  boolean
     */
    public function isEncoded()
    {
        return '' != $this->getContentEncoding();
    }

    /**
     * Return the reponse content encoding.
     *
     * @return  string
     */
    public function getContentEncoding()
    {
        return $this->getHeader() ? $this->getHeader()->get('content-encoding', '') : '';
    }

    /**
     * Return the reponse content type.
     *
     * @return  string
     */
    public function getContentType()
    {
        return $this->getHeader() ? $this->getHeader()->get('content-type', '') : '';
    }

    /**
     * Return response header.
     *
     * @return  string
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Return response infos.
     *
     * @return  string
     */
    public function getInfos()
    {
        return $this->infos;
    }

    /**
     * Return response content.
     *
     * @return  string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Return response content.
     * Decode any content-encoding (gzip or deflate) if needed
     *
     * @return  string
     */
    public function getReadableContent()
    {
        $header = $this->getHeader();
        $result = $this->getContent();

        if (!$result || !$header)
        {
            return $result;
        }

        switch ($this->getContentEncoding())
        {
            case 'gzip':
                $result = gzinflate($result); // Handle gzip encoding //gzinflate(substr($result, 10))
                break;

            case 'deflate':
                $result = gzuncompress($result); // Handle deflate encoding
                break;

            default:
                break;
        }

        return $result;
    }

    /**
     * Return converted content.
     *
     * @param   Mlz_Curl_Response_Converter $converter
     * @return  mixed
     */
    public function convertTo(Mlz_Curl_Response_Converter $converter)
    {
        return $converter->convert($this);
    }
}
