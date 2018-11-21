<?php declare(strict_types=1);

/**
 * Fluent Sanitizer
 * @license https://opensource.org/licenses/MIT MIT
 * @author Renan Cavalieri <renan@tecdicas.com>
 */

namespace Pollus\Sanitizer\Types;

class BoolType extends BaseType
{
    /**
     * @param bool|null $value
     * @param bool $nullable
     */
    public function __construct(?bool $value, bool $nullable) 
    {
        parent::__construct($value, $nullable);
    }
    
    /**
     * @return bool|null
     */
    public function val() : ?bool
    {
        return $this->val;
    }
}
