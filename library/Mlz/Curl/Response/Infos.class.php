<?php

/**
 * Response information class.
 *
 * @category    MLZ
 * @package     Mlz_Curl
 * @subpackage  Response
 * @author      François Béliveau  <francois.beliveau@my-labz.com>
 */
class Mlz_Curl_Response_Infos
{
    protected
        $contents = array();

    /**
     * Constructor.
     *
     * @param  array $contents
     */
    public function __construct(array $contents)
    {
        $this->setAll($contents);
    }

    /**
     * Return contents values.
     *
     * @return array
     */
    public function getAll()
    {
        return $this->contents;
    }

    /**
     * Get a content.
     *
     * @param  string
     * @return string
     */
    public function get($key, $default = '')
    {
        $normalizedKey = $this->normalizeContentKey($key);
        return (isset($this->contents[$normalizedKey])) ? $this->contents[$normalizedKey] : $default;
    }

    /**
     * Set a content value.
     *
     * @param  array $values
     */
    protected function setAll(array $values)
    {
        foreach ($values as $key=>$value)
        {
            $this->set($value, $key);
        }
    }

    /**
     * Set a content value.
     *
     * @param  string $value
     * @param  string $key (optional)
     */
    protected function set($value, $key = null)
    {
        $value = trim((string)$value);
        if (empty($value))
        {
            return;
        }

        if (is_null($key))
        {
            $this->contents[] = $value;
        }
        else
        {
            $this->contents[$this->normalizeContentKey($key)] = $value;
        }
    }

    /**
     * Return a normalized content key.
     *
     * @param  string $key
     * @return string
     */
    protected function normalizeContentKey($key)
    {
        return str_replace('-', '_', strtolower($key));
    }
}
