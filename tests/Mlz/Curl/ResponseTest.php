<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'/../../../library/Mlz/Curl/Autoload.class.php';
Mlz_Curl_Autoload::register();

/**
 * Curl response test class.
 *
 * @category    MLZ Test
 * @package     Mlz_Curl
 * @author      François Béliveau  <francois.beliveau@my-labz.com>
 * @link        http://www.phpunit.de/
 */
class Mlz_Curl_ResponseTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $content  = '';
        $header   = new Mlz_Curl_Response_Header();
        $infos    = new Mlz_Curl_Response_Infos(array());
        $response = new Mlz_Curl_Response($content, $header, $infos);

        $this->assertTrue($response->getHeader() instanceof Mlz_Curl_Response_Header);
        $this->assertTrue($response->getInfos() instanceof Mlz_Curl_Response_Infos);
    }

    public function testHttpCode()
    {
        $content  = '';
        $header   = new Mlz_Curl_Response_Header();
        $infos    = new Mlz_Curl_Response_Infos(array());
        $response = new Mlz_Curl_Response($content, $header, $infos);

        $this->assertFalse($response->isError());

        foreach (array(100, 200, 300) as $code)
        {
            $infos    = new Mlz_Curl_Response_Infos(array('http_code' => $code));
            $response = new Mlz_Curl_Response($content, $header, $infos);

            $this->assertFalse($response->isError());
        }
        
        foreach (array(400, 404, 500) as $code)
        {
            $infos    = new Mlz_Curl_Response_Infos(array('http_code' => $code));
            $response = new Mlz_Curl_Response($content, $header, $infos);

            $this->assertTrue($response->isError());
        }
    }

    public function testEncoding()
    {
        $content  = 'lorem ipsum';;
        $header   = new Mlz_Curl_Response_Header();
        $infos    = new Mlz_Curl_Response_Infos(array());
        $response = new Mlz_Curl_Response($content, $header, $infos);

        $this->assertFalse($response->isEncoded());
        $this->assertEquals($response->getContentEncoding(), '');
        $this->assertEquals($response->getContent(), $content);
        $this->assertEquals($response->getReadableContent(), $content);

        $header->initialize(null, 'content-encoding:gzip');
        $response = new Mlz_Curl_Response(gzdeflate($content), $header, $infos);
        $this->assertEquals($response->getContentEncoding(), 'gzip');
        $this->assertTrue($response->isEncoded());
        $this->assertEquals($response->getContent(), gzdeflate($content));
        $this->assertEquals($response->getReadableContent(), $content);

        $header->initialize(null, 'content-encoding:deflate');
        $response = new Mlz_Curl_Response(gzcompress($content), $header, $infos);
        $this->assertEquals($response->getContentEncoding(), 'deflate');
        $this->assertTrue($response->isEncoded());
        $this->assertEquals($response->getContent(), gzcompress($content));
        $this->assertEquals($response->getReadableContent(), $content);
    }
}
