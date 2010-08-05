MLZ-PHP-CURL
============

The *mlz-php-curl* library aim to make easier dealing with CURL in PHP.
The principe is simple, you create an object request and you execute it to get an object response.


STANDARD
--------
The *mlz-php-curl* library use the [Zend Framework Coding Standard for PHP](http://framework.zend.com/manual/en/coding-standard.html).


SYSTEM REQUIREMENTS
-------------------
The *mlz-php-curl* library requires PHP 5.2.0 or later.


INSTALLATION
------------

    git checkout git://github.com/francoisb/mlz-php-curl.git mlz-php-curl
    git submodule init
    git submodule update


CONFIGURATION
-------------
To be able to use *mlz-php-curl* library, you have to register the autoload (you can also use another one if you wish).

    <?php
        require_once($path_to_library.'/library/Mlz/Curl/Autoload/class.php');
        MLZ_Curl_Autoload::register();
    ?>

That's all.


USAGE
-----
    <?php
        // Create a curl request
        $request = new Mlz_Curl_Request(
            array(
                'url'                  => 'an url',
            ),
            array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST  => 'GET',
            )
        );
    
        // Execute the request and get the response
        $response = $request->execute();
    
        // Working with the response
        $content      = $response->getReadableContent();
        $xmlContent   = $response->convertTo(new Mlz_Curl_Response_Converter_Xml());
        $arrayContent = $response->convertTo(new Mlz_Curl_Response_Converter_Array());
        $header       = $response->getHeader();
        $infos        = $response->getInfos();
    ?>


TESTS
-----
All the code is unit tested with [phpUnit](http://www.phpunit.de/).

To run tests just follow these steps:

    cd ./tests
    ./run-tests.sh


LICENCE
-------
Please referred to LICENSE.txt.
