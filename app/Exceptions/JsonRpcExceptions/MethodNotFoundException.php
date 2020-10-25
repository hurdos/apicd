<?php


namespace App\Exceptions\JsonRpcExceptions;

use App\Exceptions\JsonRpcException;
use Throwable;

class MethodNotFoundException extends JsonRpcException
{
    public function __construct($message = 'Method not found', $code = self::METHOD_NOT_FOUND_ERROR_CODE, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
