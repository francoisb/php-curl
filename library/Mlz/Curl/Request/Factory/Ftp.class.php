<?php

/**
 * FTP request factory class.
 *
 * @category    MLZ
 * @package     Mlz_Curl
 * @subpackage  Request
 * @author      François Béliveau  <francois.beliveau@my-labz.com>
 */
class Mlz_Curl_Request_Factory_Ftp
{
    /**
     * Create a new FTP LIST request.
     *
     * @param  array            $curlOptions (optional)
     * @param  array            $options (optional)
     * @param  string           $classname (optional)
     * @return mlzCurlRequest
     */
    static public function createList(array $curlOptions = array(), array $options = array(), $classname = null)
    {
        $options['fix_url']                  = true;
        $curlOptions[CURLOPT_RETURNTRANSFER] = true;
        $curlOptions[CURLOPT_FTPLISTONLY]    = true;
        $curlOptions[CURLOPT_FTP_USE_EPSV]   = false;

        return Mlz_Curl_Request_Factory::create($curlOptions, $options, $classname);
    }

    /**
     * Create a new FTP GET request.
     *
     * @param  array            $curlOptions (optional)
     * @param  array            $options (optional)
     * @param  string           $classname (optional)
     * @return mlzCurlRequest
     * @todo
     */
    static public function createGet(array $curlOptions = array(), array $options = array(), $classname = null)
    {
        /*if (!isset($options['url']))
        {
            throw new RuntimeException(sprintf('option "%s" is required', 'url'));
        }

        if (!isset($options['target_dir']))
        {
            $options['target_dir'] = '/tmp';
        }

        if ('/' != substr($options['target_dir'], strlen($options['target_dir'])-1))
        {
            $options['target_dir'] .= '/';
        }

        if (isset($options['create_dir']) && $options['create_dir'] && !file_exists($options['target_dir']))
        {
            $old   = umask(0000);
            $mkdir = mkdir($options['create_dir'], 0777, true);
            umask($old);
            if (!$mkdir)
            {
                throw new RuntimeException(sprintf('Unable to get file "%s": can\'t create target dir "%s"', $options['url'], $options['create_dir']));
            }
        }

        if (!is_dir($options['target_dir']))
        {
            throw new RuntimeException(sprintf('Unable to get file "%s": target dir "%s" not exists', $options['url'], $options['target_dir']));
        }

        $option['target_file'] = tmpfile($options['target_dir']);
        if (!$option['file_handler'] = fopen($option['target_file'], 'w+'))
        {
            throw new RuntimeException(sprintf('Unable to get file "%s" : can\'t create destination file "%s"', $options['url'], $option['target_file']));
        }

        $curlOptions[CURLOPT_HEADER]         = false;
        $curlOptions[CURLOPT_RETURNTRANSFER] = true;
        $curlOptions[CURLOPT_FOLLOWLOCATION] = true;
        $curlOptions[CURLOPT_AUTOREFERER]    = true;
        $curlOptions[CURLOPT_FTP_USE_EPSV]   = false;
        $curlOptions[CURLOPT_FILE]           = $option['file_handler'];

        return Mlz_Curl_Request_Factory::create($curlOptions, $options, $classname);*/
    }

    /**
     * Create a new FTP PUT request.
     *
     * @param  array            $curlOptions (optional)
     * @param  array            $options (optional)
     * @param  string           $classname (optional)
     * @return mlzCurlRequest
     * @todo
     */
    static public function createPut($file, array $curlOptions = array(), array $options = array(), $classname = null)
    {
        /*//check is valid file
        if (!is_file($file))
        {
            throw new InvalidArgumentException('Unable to put file "'.$file.'" : file not exist');
        }
        if (!is_readable($file))
        {
            throw new InvalidArgumentException('Unable to put file "'.$file.'" : file not readable');
        }

        $options['fix_url']              = true;
        $options['url_suffix']           = basename($file);
        $curlOptions[CURLOPT_UPLOAD]     = true;
        $curlOptions[CURLOPT_INFILESIZE] = filesize($file);

        if (!$fhandler = fopen($file, 'r'))
        {
            throw new sfWebOperationException('Unable to put file "'.$file.'" : can\'t read file');
        }

        $curlOptions[CURLOPT_INFILE] = $fhandler;

        if ($asciiMode)
        {
            $curlOptions[CURLOPT_TRANSFERTEXT] = true;
        }

        if ($chmod)
        {
            $path = parse_url($url, PHP_URL_PATH);
            $curlOptions[CURLOPT_POSTQUOTE] = array("SITE CHMOD $chmod $path"));
        }

        $curlOptions[CURLOPT_FTP_USE_EPSV] = false;

        //create a sfWebOperation object
        $webOperation = new sfWebOperation($webOperationRequest);

        $result = $webOperation->call();

        //close ressources
        fclose($fhandler);

        return $result;*/
  }

    /**
     * Create a new FTP DELETE request.
     *
     * @param  string|array     $files
     * @param  array            $curlOptions (optional)
     * @param  array            $options (optional)
     * @param  string           $classname (optional)
     * @return mlzCurlRequest
     */
    static public function createDelete($files, array $curlOptions = array(), array $options = array(), $classname = null)
    {
        if (!is_array($files))
        {
            $files = array((string)$files);
        }

        $postquote = array();
        foreach ($files as $file)
        {
            $postquote[] = 'DELE '.$file;
        }

        $options['fix_url']                = true;
        $curlOptions[CURLOPT_POSTQUOTE]    = $postquote;
        $curlOptions[CURLOPT_HEADER]       = false;
        $curlOptions[CURLOPT_NOBODY]       = true;
        $curlOptions[CURLOPT_FTP_USE_EPSV] = false;

        return Mlz_Curl_Request_Factory::create($curlOptions, $options, $classname);
    }
}
