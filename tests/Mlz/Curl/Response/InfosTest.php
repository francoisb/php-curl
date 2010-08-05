<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'/../../../../library/Mlz/Curl/Autoload.class.php';
Mlz_Curl_Autoload::register();

/**
 * Curl response infos test class.
 *
 * @category    MLZ Test
 * @package     Mlz_Curl
 * @author      François Béliveau  <francois.beliveau@my-labz.com>
 * @link        http://www.phpunit.de/
 */
class Mlz_Curl_Response_InfosTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $infos = new Mlz_Curl_Response_Infos(array(
            'content-type'     => 'text/xml',
            'content_encoding' => 'gzip',
            'single'
        ));

        $this->assertEquals($infos->getAll(), array('content_type' => 'text/xml', 'content_encoding' => 'gzip', 'single'));
        $this->assertEquals($infos->get('content_type'), 'text/xml');
        $this->assertEquals($infos->get('Content-Type'), 'text/xml');
        $this->assertEquals($infos->get('Content-custom'), '');
        $this->assertEquals($infos->get('Content_custom', 'default'), 'default');
    }
}
