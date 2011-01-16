<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'/Mlz/Curl/LoggerTest.php';
require_once dirname(__FILE__).'/Mlz/Curl/RequestTest.php';
require_once dirname(__FILE__).'/Mlz/Curl/RequestMockTest.php';
require_once dirname(__FILE__).'/Mlz/Curl/Request/FactoryTest.php';
require_once dirname(__FILE__).'/Mlz/Curl/Request/Factory/HttpTest.php';
require_once dirname(__FILE__).'/Mlz/Curl/Request/Factory/FtpTest.php';
require_once dirname(__FILE__).'/Mlz/Curl/ResponseTest.php';
require_once dirname(__FILE__).'/Mlz/Curl/Response/InfosTest.php';
require_once dirname(__FILE__).'/Mlz/Curl/Response/HeaderTest.php';
require_once dirname(__FILE__).'/Mlz/Curl/Response/Converter/ArrayTest.php';
require_once dirname(__FILE__).'/Mlz/Curl/Response/Converter/XmlTest.php';

/**
 * All tests class.
 *
 * @category    MLZ Test
 * @package     Mlz_Option
 * @author      François Béliveau  <francois.beliveau@my-labz.com>
 * @link        http://www.phpunit.de/
 */
class AllTests
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('PHPUnit mlz-php-curl');
        $suite->addTestSuite('Mlz_Curl_LoggerTest');
        $suite->addTestSuite('Mlz_Curl_RequestTest');
        $suite->addTestSuite('Mlz_Curl_RequestMockTest');
        $suite->addTestSuite('Mlz_Curl_Request_FactoryTest');
        $suite->addTestSuite('Mlz_Curl_Request_Factory_HttpTest');
        $suite->addTestSuite('Mlz_Curl_Request_Factory_FtpTest');
        $suite->addTestSuite('Mlz_Curl_ResponseTest');
        $suite->addTestSuite('Mlz_Curl_Response_InfosTest');
        $suite->addTestSuite('Mlz_Curl_Response_HeaderTest');
        $suite->addTestSuite('Mlz_Curl_Response_Converter_ArrayTest');
        $suite->addTestSuite('Mlz_Curl_Response_Converter_XmlTest');

        return $suite;
    }
}
