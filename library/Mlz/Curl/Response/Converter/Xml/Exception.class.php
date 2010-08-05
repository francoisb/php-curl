<?php

/**
 * Response XML converter exception class.
 *
 * @category    MLZ
 * @package     Mlz_Curl
 * @subpackage  Response
 * @author      François Béliveau  <francois.beliveau@my-labz.com>
 */
class Mlz_Curl_Response_Converter_Xml_Exception extends Mlz_Curl_Exception
{
    protected
        $xmlErrors = array();
  
    public function __construct($message = null, array $xmlErrors = array(), $code = 0)
    {
        parent::__construct($this->createMessage($message, $xmlErrors), $code);
    }

    /**
     * Return the XML errors.
     *
     * @return array of libXMLError
     */
    public function getXmlErrors()
    {
        return $this->xmlErrors;
    }

    /**
     * Create the exception message.
     *
     * @param  string $message
     * @param  array $xmlErrors
     * @return string
     */
    protected function createMessage($message, array $xmlErrors)
    {
        $this->xmlErrors = $xmlErrors;
        $errors          = array();
        foreach ($xmlErrors as $error)
        {
            $errors[] = sprintf('[%s] %s', $error->code, trim($error->message));
        }

        return sprintf('%s%s%s', $message, count($errors) ? ":\n   * " : '', implode("\n   * ", $errors));
    }
}
