<?php

/**
 * Response converter base class.
 *
 * @category    MLZ
 * @package     Mlz_Curl
 * @subpackage  Response
 * @author      François Béliveau  <francois.beliveau@my-labz.com>
 */
abstract class Mlz_Curl_Response_Converter extends Mlz_Option
{
    /**
     * Convert a curl response.
     *
     * @param   Mlz_Curl_Response $response
     * @return  mixed
     */
    abstract public function convert(Mlz_Curl_Response $response);
}
