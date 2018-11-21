<?php declare(strict_types=1);

/**
 * Fluent Sanitizer
 * @license https://opensource.org/licenses/MIT MIT
 * @author Renan Cavalieri <renan@tecdicas.com>
 */

namespace Pollus\Sanitizer\Types;

use \LogicException;

/**
 * Float sanitization class
 */
class FloatType extends BaseType
{
    /**
     * @param float|null $value
     * @param bool $nullable
     */
    public function __construct(?float $value, bool $nullable) 
    {
        parent::__construct($value, $nullable);
    }
    
    /**
     * Round a float value
     * 
     * @param int $precision
     * @param int $mode
     * @return $this
     */
    public function round(int $precision = 0, int $mode = PHP_ROUND_HALF_UP) : FloatType
    {
        $this->val = ($this->val === null) ? $this->val : round($this->val, $precision, $mode);
        return $this;
    }
    
    /**
     * Round up
     * @return $this
     */
    public function ceil() : FloatType
    {
        $this->val = ($this->val === null) ? $this->val : ceil($this->val);
        return $this;
    }
    
    /**
     * Round down
     * @return $this
     */
    public function floor() : FloatType
    {
        $this->val = ($this->val === null) ? $this->val : floor($this->val);
        return $this;
    }
    
    /**
     * @return float|null
     */
    public function val() : ?float
    {
        return $this->val;
    }
}
