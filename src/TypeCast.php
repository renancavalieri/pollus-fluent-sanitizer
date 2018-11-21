<?php declare(strict_types=1);

/**
 * Fluent Sanitizer
 * @license https://opensource.org/licenses/MIT MIT
 * @author Renan Cavalieri <renan@tecdicas.com>
 */

namespace Pollus\Sanitizer;

use Pollus\Sanitizer\Types\StringType;
use Pollus\Sanitizer\Types\BoolType;
use Pollus\Sanitizer\Types\IntType;
use Pollus\Sanitizer\Types\FloatType;

class TypeCast 
{
    /**
     * @var bool
     */
    protected $nullable = false;
    
    /**
     * @var mixed|null
     */
    protected $value;
    
    /**
     * @param mixed $value
     */
    public function __construct($value) 
    {
        $this->value = $value;
    }
    
    /**
     * @return IntType
     */
    public function toInt()
    {
        if ($this->nullable === true && ($this->value === "" || $this->value === null))
        {
            $value = null;
        }
        else if ($this->nullable === false && ($this->value === "" || $this->value === null))
        {
            $value = 0;
        }
        else
        {
            $value = (int) $this->value;
        }
        
        return new IntType($value, $this->nullable);
    }
    
    /**
     * @return StringType
     */
    public function toString() : StringType
    {
        if ($this->nullable === true && ($this->value === "" || $this->value === null))
        {
            $value = null;
        }
        else
        {
            $value = (string) $this->value;
        }
        
        return new StringType($value, $this->nullable);
    }
    
    /**
     * Casts 0, "0", false and "false" to boolean false.
     * 
     * Casts anything else to boolean true.
     * 
     * @return BoolType
     */
    public function toBool() : BoolType
    {
        if ($this->nullable === true && ($this->value === "" || $this->value === null))
        {
            $value = null;
        }
        else if ($this->value === 0 || (is_string($this->value) && strtolower($this->value) === "false"))
        {
            $value = false;
        }
        else if ($this->value === "true" || $this->value == 1)
        {
            $value = true;
        }
        else
        {
            $value = (bool) $this->value;
        }
        
        return new BoolType($value, $this->nullable);
    }
    
    /**
     * @param string $decimal
     * @return FloatType
     */
    public function toFloat(string $decimal = ".") : FloatType
    {
        if ($this->nullable === true && ($this->value === "" || $this->value === null))
        {
            $value = null;
        }
        else if ($this->nullable === false && ($this->value === "" || $this->value === null))
        {
            $value = 0.0;
        }
        else
        {
            $value = preg_replace("/[^0-9" . $decimal . "]/", "", $this->value);
            $value = str_replace($decimal, ".", $value);
            $value = (float) $value;
        }
        
        
        return new FloatType($value, $this->nullable);
    }
    
    /**
     * Set TRUE to allow nullable values.
     * 
     * Note: Most of sanitization methods will do nothing if a null value be 
     * supplied
     * 
     * @param type $nullable
     * @return $this
     */
    public function nullable($nullable = true) : TypeCast
    {
        $this->nullable = $nullable;
        return $this;
    }
}
