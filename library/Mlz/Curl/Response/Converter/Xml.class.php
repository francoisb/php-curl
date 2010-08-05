<?php

/**
 * Response converter to xml class.
 *
 * @category    MLZ
 * @package     Mlz_Curl
 * @subpackage  Response
 * @author      François Béliveau  <francois.beliveau@my-labz.com>
 */
class Mlz_Curl_Response_Converter_Xml extends Mlz_Curl_Response_Converter
{
    /**
     * Convert a curl response to an xml.
     *
     * @param   Mlz_Curl_Response $response
     * @return  SimpleXMLElement
     * @throws  RuntimeException
     * @throws  Mlz_Curl_Response_Converter_Xml_Exception
     */
    public function convert(Mlz_Curl_Response $response)
    {
        $contentType = $response->getContentType();
        $content     = $response->getReadableContent();

        if (!preg_match('/(x|ht)ml/i', $contentType) && !$this->getOption('force', false))
        {
            throw new RuntimeException(sprintf('The content type "%s" can\'t be converted to XML.', $contentType));
        }

        $libxmlUseInternalErrors = libxml_use_internal_errors(true);
        $result                  = @simplexml_load_string($content);
        $xmlErrors               = libxml_get_errors();
        libxml_clear_errors();
        libxml_use_internal_errors($libxmlUseInternalErrors); // restore the previous configuration
        if (!$result instanceof SimpleXMLElement || count($xmlErrors))
        {
            throw new Mlz_Curl_Response_Converter_Xml_Exception('Unable to convert content to XML', $xmlErrors);
        }

        return $result;
    }
}
