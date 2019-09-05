<?php


namespace App\Exceptions;

use Exception;


abstract class BaseException extends Exception
{
    abstract protected function exceptions();
    public function __construct($code, $message= '')
    {
        $exceptions = $this->exceptions();
        $message = $message ?: $exceptions[$code];
        parent::__construct($message, $code);
    }
}
