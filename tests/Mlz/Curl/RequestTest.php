<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'/../../../library/Mlz/Curl/Autoload.class.php';
Mlz_Curl_Autoload::register();

/**
 * Curl request test class.
 *
 * @category    MLZ Test
 * @package     Mlz_Curl
 * @author      François Béliveau  <francois.beliveau@my-labz.com>
 * @link        http://www.phpunit.de/
 */
class Mlz_Curl_RequestTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $request = new Mlz_Curl_Request();
        $this->assertEquals($request->getCurlOptions(), array());

        $option = new Mlz_Curl_Request(array(), array('option1' => 'option1_value'));
        $this->assertEquals($option->getCurlOptions(), array('option1' => 'option1_value'));

        $option->setCurlOptions(array('option2' => 'option2_value'));
        $this->assertEquals($option->getCurlOptions(), array('option1' => 'option1_value', 'option2' => 'option2_value'));

        $option->setCurlOptions(array('option2' => 'option2_val'));
        $option->setCurlOptions(array('option' => 'option_val'));
        $this->assertEquals($option->getCurlOptions(), array('option1' => 'option1_value', 'option2' => 'option2_val', 'option' => 'option_val'));

        $this->assertTrue($option->hasCurlOption('option1'));
        $this->assertFalse($option->hasCurlOption('option3'));

        $this->assertEquals($option->getCurlOption('option1'), 'option1_value');
        $this->assertEquals($option->getCurlOption('option3'), '');
        $this->assertEquals($option->getCurlOption('option3', 'default'), 'default');
    }
}
