<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'/../../../../library/Mlz/Curl/Autoload.class.php';
Mlz_Curl_Autoload::register();

/**
 * Curl response header test class.
 *
 * @category    MLZ Test
 * @package     Mlz_Curl
 * @author      François Béliveau  <francois.beliveau@my-labz.com>
 * @link        http://www.phpunit.de/
 */
class Mlz_Curl_Response_HeaderTest extends PHPUnit_Framework_TestCase
{
  public function test()
  {
      $header  = new Mlz_Curl_Response_Header();
      $headers = array(
          'content-type: text/xml',
          'content-encoding: gzip',
          'single',
          );

      foreach ($headers as $h)
      {
          $header->initialize(null, $h);
      }

      $this->assertEquals($header->getAll(), array('Content-Type' => 'text/xml', 'Content-Encoding' => 'gzip', 'single'));
      $this->assertEquals($header->get('content-type'), 'text/xml');
      $this->assertEquals($header->get('Content-Type'), 'text/xml');
      $this->assertEquals($header->get('Content-custom'), '');
      $this->assertEquals($header->get('Content-custom', 'default'), 'default');
    }
}
