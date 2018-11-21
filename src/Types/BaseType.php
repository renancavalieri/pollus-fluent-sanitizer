<?php declare(strict_types=1);

/**
 * Fluent Sanitizer
 * @license https://opensource.org/licenses/MIT MIT
 * @author Renan Cavalieri <renan@tecdicas.com>
 */

namespace Pollus\Sanitizer\Types;

use Pollus\Sanitizer\Exceptions\InvalidInputException;

class BaseType 
{
    /**
     * @var mixed
     */
    protected $val;
    
    /**
     * @param mixed|null $value
     * @param bool $nullable
     * @throws LogicException
     */
    public function __construct($value, bool $nullable) 
    {
        if ($nullable === false && $value === null)
        {
            throw new InvalidInputException("The value cannot be null when nullable is not false");
        }
        
        $this->val = $value;
    }
}
