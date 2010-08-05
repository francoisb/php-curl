<?php

/**
 * mlzCurlRequestFactoryFtp test using PhpUnit.
 *
 * @package    mlzCurl
 * @subpackage test
 * @author     François Béliveau  <francois.beliveau@my-labz.com>
 * @link       http://www.phpunit.de/
 */

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'/../../../lib/autoload/mlzCurlAutoload.class.php';
mlzCurlAutoload::register();

class mlzCurlRequestFactoryFtpTest extends PHPUnit_Framework_TestCase
{
  public function test()
  {
    $request = mlzCurlRequestFactoryFtp::createList();
    $request = mlzCurlRequestFactoryFtp::createGet();
    $request = mlzCurlRequestFactoryFtp::createPut();
    $request = mlzCurlRequestFactoryFtp::createDelete();
  }
}
