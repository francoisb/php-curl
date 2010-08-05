<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'/../../../library/Mlz/Curl/Autoload.class.php';
Mlz_Curl_Autoload::register();

/**
 * Curl request factory test class.
 *
 * @category    MLZ Test
 * @package     Mlz_Curl
 * @author      François Béliveau  <francois.beliveau@my-labz.com>
 * @link        http://www.phpunit.de/
 */
class Mlz_Curl_LoggerTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $dir   = dirname(__FILE__).'/../../data/';
        $files = array('mlz-php-curl.log', 'curl.log');
        foreach ($files as $file)
        {
            if (is_file($dir.$file))
            {
                unlink($dir.$file);
            }
        }

        $logger = new Mlz_Curl_Logger(array('log_dir' => $dir));
        $logger->start();
        $this->assertTrue(is_resource($logger->getFileHandler()));
        $logger->stop();
        $this->assertTrue(is_file($dir.'mlz-php-curl.log'));

        $logger = new Mlz_Curl_Logger(array('log_dir' => $dir, 'log_file' => 'curl.log'));
        $logger->start();
        $this->assertTrue(is_resource($logger->getFileHandler()));
        $logger->stop();
        $this->assertTrue(is_file($dir.'curl.log'));

        foreach ($files as $file)
        {
            if (is_file($dir.$file))
            {
                unlink($dir.$file);
            }
        }
    }

    public function testUnStartedException()
    {
        $this->setExpectedException('RuntimeException');

        $logger = new Mlz_Curl_Logger();
        $logger->getFileHandler();
    }

    public function testNoLogDirOptionException()
    {
        $this->setExpectedException('InvalidArgumentException');

        $logger = new Mlz_Curl_Logger();
        $logger->start();
    }
 }
