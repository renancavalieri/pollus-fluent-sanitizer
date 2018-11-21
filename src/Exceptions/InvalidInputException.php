<?php

namespace Pollus\Sanitizer\Exceptions;

use \Exception;

/**
 * This exception is thrown when strict mode is enabled and the a invalid argument
 * was supplied on get() or post() methods from Input class.
 */
class InvalidInputException extends Exception
{

}
