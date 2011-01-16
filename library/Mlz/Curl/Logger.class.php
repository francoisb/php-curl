<?php

/**
 * Logger class.
 *
 * @category    MLZ
 * @package     Mlz_Curl
 * @subpackage  Logger
 * @author      François Béliveau  <francois.beliveau@my-labz.com>
 */
class Mlz_Curl_Logger extends Mlz_Option
{
    protected
        $fileHandler = null;

    /**
     * Return the file handler.
     *
     * @return resource
     * @throws  RuntimeException
     */
    public function getFileHandler()
    {
        if (!$this->isValidResource())
        {
            throw new RuntimeException('Invalid resource, please use start function first');
        }

        return $this->fileHandler;
    }

    /**
     * Initialize the log file handler.
     */
    public function start()
    {
        if (!$this->isValidResource())
        {
            $dir      = realpath($this->getRequiredOption('log_dir'));
            $file     = $this->getOption('log_file', 'mlz-php-curl.log');
            $filepath = $dir.DIRECTORY_SEPARATOR.$file;
            if (empty($filepath))
            {
                throw new InvalidArgumentException('Empty log file path');
            }

            $fileExists = file_exists($filepath);
            if (!$fileExists)
            {
                $old = umask(0000);
            }

            $this->fileHandler = fopen($filepath, 'a+b');

            if (!$fileExists)
            {
                chmod($filepath, 0766);
                umask($old);
            }
        }
    }

    /**
     * Free the log file handler.
     */
    public function stop()
    {
        if ($this->isValidResource())
        {
            fclose($this->fileHandler);
        }

        $this->fileHandler = null;
    }

    /**
     * Check whether the log resource is valid or not.
     *
     * @return  boolean
     */
    protected function isValidResource()
    {
        return (is_resource($this->fileHandler) && 'stream' == get_resource_type($this->fileHandler));
    }
}
