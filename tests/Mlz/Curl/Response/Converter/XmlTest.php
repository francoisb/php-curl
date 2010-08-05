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
class Mlz_Curl_Response_Converter_XmlTest extends PHPUnit_Framework_TestCase
{
    public function testXml()
    {
        $content = file_get_contents(dirname(__FILE__).'/../../../../data/response/response.xml');
        $header  = new Mlz_Curl_Response_Header();
        $infos   = new Mlz_Curl_Response_Infos(array());

        $header->initialize(null, 'content-type: text/xml');

        $response  = new Mlz_Curl_Response($content, $header, $infos);
        $converter = new Mlz_Curl_Response_Converter_Xml(array());
        $converted = $converter->convert($response);

        $this->assertTrue($converted instanceof SimpleXMLElement);
        $this->assertEquals((string)$converted[0]->CD[0]->TITLE, 'Empire Burlesque');
        $this->assertEquals((string)$converted[0]->CD[25]->ARTIST, 'Joe Cocker');
    }

    public function testHtml()
    {
        $content   = file_get_contents(dirname(__FILE__).'/../../../../data/response/response.html');
        $header    = new Mlz_Curl_Response_Header();
        $infos     = new Mlz_Curl_Response_Infos(array());
        $response  = new Mlz_Curl_Response($content, $header, $infos);
        $converter = new Mlz_Curl_Response_Converter_Xml(array('force' => true));
        $converted = $converter->convert($response);

        $this->assertTrue($converted instanceof SimpleXMLElement);
        $this->assertEquals((string)$converted[0]->body->h1[0], 'CATALOG');
    }

    public function testInvalidHeaderException()
    {
        $this->setExpectedException('RuntimeException');

        $content   = file_get_contents(dirname(__FILE__).'/../../../../data/response/response.bad.html');
        $header    = new Mlz_Curl_Response_Header();
        $infos     = new Mlz_Curl_Response_Infos(array());
        $response  = new Mlz_Curl_Response($content, $header, $infos);
        $converter = new Mlz_Curl_Response_Converter_Xml(array());
        $converted = $converter->convert($response);
    }

    public function testInvalidContentException()
    {
        $this->setExpectedException('Mlz_Curl_Response_Converter_Xml_Exception');

        $content   = file_get_contents(dirname(__FILE__).'/../../../../data/response/response.bad.xml');
        $header    = new Mlz_Curl_Response_Header();
        $infos     = new Mlz_Curl_Response_Infos(array());
        $response  = new Mlz_Curl_Response($content, $header, $infos);
        $converter = new Mlz_Curl_Response_Converter_Xml(array('force' => true));
        $converted = $converter->convert($response);
    }
}
