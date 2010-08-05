<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'/../../../library/Mlz/Curl/Autoload.class.php';
Mlz_Curl_Autoload::register();

/**
 * Curl request mock test class.
 *
 * @category    MLZ Test
 * @package     Mlz_Curl
 * @author      François Béliveau  <francois.beliveau@my-labz.com>
 * @link        http://www.phpunit.de/
 */
class Mlz_Curl_RequestMockTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $content  = 'mock content';
        $request  = new Mlz_Curl_RequestMock(array('response_mock' => $content), array());
        $response = $request->execute();
        $this->assertEquals($response->getContent(), $content);
        $this->asserttrue($response instanceof Mlz_Curl_Response);

        $header   = new Mlz_Curl_Response_Header();
        $header->initialize(null, 'content-type:text/xml');
        $infos    = new Mlz_Curl_Response_Infos(array('http_code' => 200));
        $request  = new Mlz_Curl_RequestMock(array('response_mock' => $content, 'response_infos_mock' => $infos, 'response_headers_mock' => $header), array());
        $response = $request->execute();
        $this->assertEquals($response->getContent(), $content);
        $this->assertEquals($response->getHeader(), $header);
        $this->assertEquals($response->getInfos(), $infos);
        $this->asserttrue($response instanceof Mlz_Curl_Response);
    }

    public function testNoMockContentException()
    {
        $this->setExpectedException('InvalidArgumentException');

        $request  = new Mlz_Curl_RequestMock(array(), array());
        $response = $request->execute();
    }
}
