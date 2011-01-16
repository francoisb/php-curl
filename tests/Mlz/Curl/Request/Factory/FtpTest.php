<?php

/**
 * mlzCurlRequestFactoryFtp test using PhpUnit.
 *
 * @package    mlzCurl
 * @subpackage test
 * @author     François Béliveau  <francois.beliveau@my-labz.com>
 * @link       http://www.phpunit.de/
 * @todo
 */

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'/../../../../../library/Mlz/Curl/Autoload.class.php';
Mlz_Curl_Autoload::register();

class Mlz_Curl_Request_Factory_FtpTest extends PHPUnit_Framework_TestCase
{
    /*public function test()
    {
        $request = Mlz_Curl_Request_Factory_Ftp::createList();
        $request = Mlz_Curl_Request_Factory_Ftp::createGet();
        $request = Mlz_Curl_Request_Factory_Ftp::createPut();
        $request = Mlz_Curl_Request_Factory_Ftp::createDelete();
    }*/
}
