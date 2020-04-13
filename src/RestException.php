<?php


namespace LaraDevs\AuthRemote;

use Exception;
use Throwable;

class RestException extends Exception
{
    public function __construct($message = '', $code = 0, Throwable $previous=null)
    {
        parent::__construct($message, $code, $previous);
    }

}
