<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'/../../../../library/Mlz/Curl/Autoload.class.php';
Mlz_Curl_Autoload::register();

/**
 * Curl request factory test class.
 *
 * @category    MLZ Test
 * @package     Mlz_Curl
 * @author      François Béliveau  <francois.beliveau@my-labz.com>
 * @link        http://www.phpunit.de/
 */
class Mlz_Curl_Request_FactoryTest extends PHPUnit_Framework_TestCase
{
    public function testPrefixAndSuffix()
    {
        Mlz_Curl_Request_Factory::setSuffix('');
        Mlz_Curl_Request_Factory::setPrefix('');
        $this->assertEquals('', Mlz_Curl_Request_Factory::getSuffix());
        $this->assertEquals('', Mlz_Curl_Request_Factory::getPrefix());

        Mlz_Curl_Request_Factory::setSuffix('Suffix');
        Mlz_Curl_Request_Factory::setPrefix('Prefix');
        $this->assertEquals('Suffix', Mlz_Curl_Request_Factory::getSuffix());
        $this->assertEquals('Prefix', Mlz_Curl_Request_Factory::getPrefix());

        Mlz_Curl_Request_Factory::setSuffix('');
        Mlz_Curl_Request_Factory::setPrefix('');
    }

    public function testOptions()
    {
        $this->assertEquals(array(), Mlz_Curl_Request_Factory::getDefaultOptions());
        $this->assertEquals(array(), Mlz_Curl_Request_Factory::getDefaultCurlOptions());

        Mlz_Curl_Request_Factory::setDefaultOptions(array('foo' => 'bar', 'f' => 'b'));
        Mlz_Curl_Request_Factory::setDefaultCurlOptions(array('bar' => 'foo'));
        $this->assertEquals(array('foo' => 'bar', 'f' => 'b'), Mlz_Curl_Request_Factory::getDefaultOptions());
        $this->assertEquals(array('bar' => 'foo'), Mlz_Curl_Request_Factory::getDefaultCurlOptions());

        Mlz_Curl_Request_Factory::setDefaultOptions(array());
        Mlz_Curl_Request_Factory::setDefaultCurlOptions(array());
    }

    public function testCreate()
    {
        Mlz_Curl_Request_Factory::setSuffix('Mock');

        $request = Mlz_Curl_Request_Factory::create();
        $this->assertEquals(get_class($request), 'Mlz_Curl_RequestMock');
        $this->assertEquals(array(), $request->getCurlOptions());
        $this->assertEquals(array(), $request->getOptions());

        Mlz_Curl_Request_Factory::setSuffix('');

        $request = Mlz_Curl_Request_Factory::create();
        $this->assertEquals(get_class($request), 'Mlz_Curl_Request');
        $this->assertEquals(array(), $request->getCurlOptions());
        $this->assertEquals(array(), $request->getOptions());

        $request = Mlz_Curl_Request_Factory::create(array('foo' => 'bar'), array('bar' => 'foo'), 'Mlz_Curl_RequestMock');
        $this->assertEquals(get_class($request), 'Mlz_Curl_RequestMock');
        $this->assertEquals(array('foo' => 'bar'), $request->getCurlOptions());
        $this->assertEquals(array('bar' => 'foo'), $request->getOptions());

        Mlz_Curl_Request_Factory::setDefaultCurlOptions(array('foo' => 'bar', 'f' => 'b'));
        Mlz_Curl_Request_Factory::setDefaultOptions(array('bar' => 'foo'));

        $request = Mlz_Curl_Request_Factory::create(array('foo' => 'bar2'), array('bar2' => 'foo'));
        $this->assertEquals(get_class($request), 'Mlz_Curl_Request');
        $this->assertEquals(array('foo' => 'bar2', 'f' => 'b'), $request->getCurlOptions());
        $this->assertEquals(array('bar' => 'foo', 'bar2' => 'foo'), $request->getOptions());

        Mlz_Curl_Request_Factory::setDefaultOptions(array());
        Mlz_Curl_Request_Factory::setDefaultCurlOptions(array());
    }

    public function testUnknownClassException()
    {
        $this->setExpectedException('InvalidArgumentException');

        Mlz_Curl_Request_Factory::setSuffix('Dummy');

        $request = Mlz_Curl_Request_Factory::create();
    }

    public function testInvalidClassException()
    {
        $this->setExpectedException('InvalidArgumentException');

        $request = Mlz_Curl_Request_Factory::create(array(), array(), 'Mlz_Curl_Response');
    }
}
