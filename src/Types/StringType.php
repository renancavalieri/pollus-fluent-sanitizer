<?php declare(strict_types=1);

/**
 * Fluent Sanitizer
 * @license https://opensource.org/licenses/MIT MIT
 * @author Renan Cavalieri <renan@tecdicas.com>
 */

namespace Pollus\Sanitizer\Types;

/**
 * String sanitization class
 */
class StringType extends BaseType
{
    protected $default_encoding = 'UTF-8';
    
    /**
     * @param string|null $value
     * @param bool $nullable
     */
    public function __construct(?string $value, bool $nullable) 
    {
        parent::__construct($value, $nullable);
    }
    
    /**
     * @return $this
     */
    public function upper() : StringType
    {
        $this->val = ($this->val === null) ? $this->val : mb_convert_case($this->val, MB_CASE_UPPER, $this->default_encoding);
        return $this;
    }
    
    /**
     * @return $this
     */
    public function lower() : StringType
    {
        $this->val = ($this->val === null) ? $this->val : mb_convert_case($this->val, MB_CASE_LOWER, $this->default_encoding);
        return $this;
    }
    
    /**
     * @param string $mask
     */
    public function trim(string $mask = "\t\n\r\0\x0B") : StringType
    {
        $this->val = ($this->val === null) ? $this->val : trim($this->val);
        return $this;
    }
    
    /**
     * @return $this
     */
    public function captalize() : StringType
    {
        $this->val = ($this->val === null) ? $this->val : mb_convert_case($this->val, MB_CASE_TITLE, $this->default_encoding);
        return $this;
    }
    
    /**
     * @return $this
     */
    public function upperFirst() : StringType
    {
        $this->val = ($this->val === null) ? $this->val : $this->mb_ucfirst(mb_convert_case($this->val, MB_CASE_LOWER, $this->default_encoding));
        return $this;
    }
    
    /**
     * @param string $mask
     * @return $this
     */
    public function rtrim(string $mask = null) : StringType
    {
        $this->val = ($this->val === null) ? $this->val : rtrim($this->val, $mask);
        return $this;
    }
    
    /**
     * @param string $mask
     * @return $this
     */
    public function ltrim(string $mask = null) : StringType
    {
        $this->val = ($this->val === null) ? $this->val : ltrim($this->val, $mask);
        return $this;
    }
    
    /**
     * Default string sanitization
     * 
     * @param int $filter - PHP FILTER_*
     * @param int|array $options - FILTER_FLAG_* 
     * @return $this
     */
    public function sanitize(int $filter = FILTER_SANITIZE_STRING, int $options = FILTER_FLAG_NO_ENCODE_QUOTES) : StringType
    {
        $this->val = ($this->val === null) ? $this->val : trim(filter_var($this->val, $filter, $options));
        return $this;
    }
    
    /**
     * Return the sanitized value
     * 
     * @return string|null
     */
    public function val() : ?string
    {
        return $this->val;
    }
    
    /**
     * Perform an addslashes.
     * 
     * WARNING: This shouldn't be used to escape queries! You should ALWAYS use 
     * parameterized queries to avoid SQL Injection.
     */
    public function escape() : StringType
    {
        $this->val = ($this->val === null) ? $this->val : addslashes($this->val);
        return $this;
    }
    
    /**
     * Perform a str_replace
     * 
     * @param string $search
     * @param string $replace
     * @return $this
     */
    public function replace(string $search, string $replace) : StringType
    {
        $this->val = ($this->val === null) ? $this->val : str_replace($search, $replace, $this->val);
        return $this;
    }
    
    /**
     * Concats a string before or after
     * 
     * @param string|null $before
     * @param string|null $after
     */
    public function concat(?string $before, ?string $after) : StringType
    {
        if ($before !== null)
        {
            $this->val = ($this->val === null) ? $this->val : $before . $this->val;
        }
        if ($after !== null)
        {
            $this->val = ($this->val === null) ? $this->val : $this->val . $after;
        } 
        return $this;
    }
    
    /**
     * Perform a strrev
     * 
     * @return $this
     */
    public function reverse() : StringType
    {
        $this->val = ($this->val === null) ? $this->val : strrev($this->val);
        return $this;
    }
    
    /**
     * Perform a substr 
     * 
     * @return $this
     */
    public function substr(int $start, int $lenght = null) : StringType
    {
        $this->val = ($this->val === null) ? $this->val : mb_substr($this->val, $start, $lenght, $this->default_encoding);
        return $this;
    }
    
    /**
     * Proper name capitalization
     * 
     * @return $this
     */
    public function capitalizeName() : StringType
    {
        if ($this->val !== null)
        {
            $word_splitters = [' ', '-', "O'", "L'", "D'", 'St.', 'Mc', 'Mac'];
            $lowercase_exceptions = ['the', 'van', 'den', 'von', 'und', 'der', 'de', 'di', 'da', 'do' ,'of', 'and', "l'", "d'"];
            $uppercase_exceptions = ["II", "I", 'III', 'IV', 'VI', 'VII', 'VIII', 'IX'];
            
            $string = mb_convert_case($this->val, MB_CASE_LOWER, $this->default_encoding);
            
            foreach ($word_splitters as $delimiter)
            {
                $words = explode($delimiter, $string);
                $newwords = array();
                foreach ($words as $word)
                {
                    $upper_word = mb_convert_case($this->val, MB_CASE_UPPER, $this->default_encoding);
                    if (in_array($upper_word, $uppercase_exceptions))
                    {
                        $word = $upper_word;
                    }
                    else if (!in_array($word, $lowercase_exceptions))
                    {
                        $word = $this->mb_ucfirst($word);
                    }
                    $newwords[] = $word;
                }
                $lower_delimiter = mb_convert_case($delimiter, MB_CASE_LOWER, $this->default_encoding);
                if (in_array($lower_delimiter, $lowercase_exceptions))
                {
                    $delimiter = $lower_delimiter;
                }
                $string = join($delimiter, $newwords);
            }
            
            $this->val = $string;
        }
        return $this;
    }
    
    
    /**
     * Set the default encoding used in mb_* functions
     * 
     * @param string $encoding
     */
    public function setEncoding(string $encoding) : StringType
    {
        $this->default_encoding = $encoding;
    }
    
    /**
     * 
     * @return $this
     */
    public function convertEncoding() : StringType
    {
        if ($this->val !== null)
        {
            $this->val = mb_convert_encoding($string, $this->default_encoding, mb_detect_encoding($string, "UTF-8, ISO-8859-1, ISO-8859-15", true));
        }
        return $this;
    }
    
    /**
     * Internal ucfirst code
     * @param string $string
     * @return type
     */
    protected function mb_ucfirst(string $string)
    {
        $str_upper = mb_strtoupper(mb_substr($string, 0, 1, $this->default_encoding), $this->default_encoding);
        $str_untouch = mb_substr($string, 1, null, $this->default_encoding);
        return $str_upper . $str_untouch;
    }
    
}
