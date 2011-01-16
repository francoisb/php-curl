<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'/../../../../../library/Mlz/Curl/Autoload.class.php';
Mlz_Curl_Autoload::register();

/**
 * Curl request HTTP factory test class.
 *
 * @category    MLZ Test
 * @package     Mlz_Curl
 * @author      François Béliveau  <francois.beliveau@my-labz.com>
 * @link        http://www.phpunit.de/
 * @todo
 */
class Mlz_Curl_Request_Factory_HttpTest extends PHPUnit_Framework_TestCase
{
    /*public function testCreateGet()
    {
        Mlz_Curl_Request_Factory::setSuffix('');
        Mlz_Curl_Request_Factory::setPrefix('');
        $request = Mlz_Curl_Request_Factory_Http::createGet(array(), array('url' => 'http://my-labz.com/'));

        $request->execute();
    }

    public function testCreatePost()
    {
        $request = Mlz_Curl_Request_Factory_Http::createPost(array('foo' => 'bar'));
    }*/
}
