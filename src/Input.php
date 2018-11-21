<?php declare(strict_types=1);

/**
 * Fluent Sanitizer
 * @license https://opensource.org/licenses/MIT MIT
 * @author Renan Cavalieri <renan@tecdicas.com>
 */

namespace Pollus\Sanitizer;

use Pollus\Sanitizer\Exceptions\InvalidInputException;
use Pollus\Sanitizer\TypeCast;

class Input 
{
    /**
     * @var bool
     */
    protected $strict;

    /**
     * Set TRUE to allow this object throws exceptions if the supplied key wasn't 
     * found in $_GET, $_POST or $_SERVER variables.
     * 
     * This doesn't affect var() method.
     * 
     * @param bool $enabled
     * @return $this
     */
    public function setStrictMode(bool $enabled = true) : Input
    {
        $this->strict = $enabled;
        return $this;
    }
    
    /**
     * Return a new {@see TypeCast} from $_GET
     * 
     * @param type $get_var
     * @return \Pollus\Sanitizer\TypeCast
     * @throws InvalidInputException
     */
    public function get($get_var) : TypeCast
    {        
        if ( ($this->strict === true) && (isset($_GET[$get_var]) === false) )
        {
            throw new InvalidInputException("Cannot find '$get_var' key in \$_GET");
        }
        return new TypeCast($_GET[$get_var] ?? null);
    }
    
    /**
     * Return a new {@see TypeCast} from $_POST
     * 
     * @param type $post_var
     * @return \Pollus\Sanitizer\TypeCast
     * @throws InvalidInputException
     */
    public function post($post_var) : TypeCast
    {
        if ( ($this->strict === true) && (isset($_POST[$post_var]) === false) )
        {
            throw new InvalidInputException("Cannot find '$post_var' key in \$_GET");
        }
        return new TypeCast($_POST[$post_var] ?? null);
    }
    
    /**
     * Return a new {@see TypeCast} from $_SERVER
     * 
     * @param type $server_var
     * @return \Pollus\Sanitizer\TypeCast
     * @throws InvalidInputException
     */
    public function server($server_var) : TypeCast
    {
        if ( ($this->strict === true) && (isset($_SERVER[$server_var]) === false) )
        {
            throw new InvalidInputException("Cannot find '$server_var' key in \$_GET");
        }
        return new TypeCast($_SERVER[$server_var] ?? null);
    }
    
    /**
     * Return a new {@see TypeCast} from $_SERVER
     * 
     * @param type $server_var
     * @return \Pollus\Sanitizer\TypeCast
     * @throws InvalidInputException
     */
    public function var($var) : TypeCast
    {
        return new TypeCast($var);
    }
}
