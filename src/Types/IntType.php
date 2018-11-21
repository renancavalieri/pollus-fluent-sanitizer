<?php declare(strict_types=1);

/**
 * Fluent Sanitizer
 * @license https://opensource.org/licenses/MIT MIT
 * @author Renan Cavalieri <renan@tecdicas.com>
 */

namespace Pollus\Sanitizer\Types;

class IntType extends BaseType
{
    /**
     * @param int|null $value
     * @param bool $nullable
     */
    public function __construct(?int $value, bool $nullable) 
    {
        parent::__construct($value, $nullable);
    }
    
    /**
     * @return int|null
     */
    public function val() : ?int
    {
        return $this->val;
    }
}
