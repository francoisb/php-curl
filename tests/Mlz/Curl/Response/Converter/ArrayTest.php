<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'/../../../../../library/Mlz/Curl/Autoload.class.php';
Mlz_Curl_Autoload::register();

/**
 * Curl response infos test class.
 *
 * @category    MLZ Test
 * @package     Mlz_Curl
 * @author      François Béliveau  <francois.beliveau@my-labz.com>
 * @link        http://www.phpunit.de/
 */
class Mlz_Curl_Response_Converter_ArrayTest extends PHPUnit_Framework_TestCase
{
    public function testText()
    {
        $content   = file_get_contents(dirname(__FILE__).'/../../../../data/response/response.txt');
        $header    = new Mlz_Curl_Response_Header();
        $infos     = new Mlz_Curl_Response_Infos(array());
        $response  = new Mlz_Curl_Response($content, $header, $infos);
        $converter = new Mlz_Curl_Response_Converter_Array(array());
        $converted = $converter->convert($response);

        $this->assertTrue(is_array($converted));
        $this->assertEquals(count($converted), 210);
        $this->assertEquals($converted[0], 'CATALOG');
    }

    public function testJson()
    {
        $content = file_get_contents(dirname(__FILE__).'/../../../../data/response/response.json');
        $header  = new Mlz_Curl_Response_Header();
        $infos   = new Mlz_Curl_Response_Infos(array());

        $header->initialize(null, 'content-type: application-json');

        $response  = new Mlz_Curl_Response($content, $header, $infos);
        $converter = new Mlz_Curl_Response_Converter_Array(array());
        $converted = $converter->convert($response);

        $this->assertTrue(is_array($converted));
        $this->assertEquals(count($converted), 210);
        $this->assertEquals($converted[0], 'CATALOG');
    }

    public function testJsonException()
    {
        $this->setExpectedException('RuntimeException');

        $content   = file_get_contents(dirname(__FILE__).'/../../../../data/response/response.bad.json');
        $header    = new Mlz_Curl_Response_Header();
        $infos     = new Mlz_Curl_Response_Infos(array());
        $response  = new Mlz_Curl_Response($content, $header, $infos);
        $converter = new Mlz_Curl_Response_Converter_Array(array('type' => 'json'));
        $converted = $converter->convert($response);
    }
}
