<?php

/**
 * Response converter to array class.
 *
 * @category    MLZ
 * @package     Mlz_Curl
 * @subpackage  Response
 * @author      François Béliveau  <francois.beliveau@my-labz.com>
 */
class Mlz_Curl_Response_Converter_Array extends Mlz_Curl_Response_Converter
{
    /**
     * Convert a curl response to an array.
     *
     * @param   Mlz_Curl_Response $response
     * @return  array
     * @throws  Exception
     * @throws  RuntimeException
     */
    public function convert(Mlz_Curl_Response $response)
    {
        $content = $response->getReadableContent();

        switch(true)
        {
            case $this->getOption('type') == 'json' || false !== strpos($response->getContentType(), 'json'):
                $result = $this->convertJson($content);
                break;

            default:
                $result = $this->convertText($content);
                break;
        }

        if (!is_array($result))
        {
            throw new RuntimeException('Unable to convert response content into array.');
        }

        return $result;
    }

    /**
     * Convert text to an array.
     *
     * @param   string $content
     * @return  array
     */
    protected function convertText($content)
    {
        return preg_split('/[\r\n]+/', $content, -1, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * Convert text to an array.
     *
     * @param   string $content
     * @return  array
     * @throws  RuntimeException
     */
    protected function convertJson($content)
    {
        $result = json_decode($content, true);

        if (function_exists('json_last_error'))
        {
            switch (json_last_error())
            {
                case JSON_ERROR_DEPTH:
                    throw new RuntimeException('The maximum stack depth has been exceeded..');

                case JSON_ERROR_CTRL_CHAR:
                    throw new RuntimeException('Control character error, possibly incorrectly encoded.');

                case JSON_ERROR_SYNTAX:
                    throw new RuntimeException('Syntax error.');

                case JSON_ERROR_UTF8:
                    throw new RuntimeException('Malformed UTF-8 characters, possibly incorrectly encoded.');

                case JSON_ERROR_NONE:
                    // nothing
                    break;

                default:
                    throw new RuntimeException('Unable to decode json string.');
            }
        }

        return $result;
    }
}
