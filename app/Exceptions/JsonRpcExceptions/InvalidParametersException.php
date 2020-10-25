<?php


namespace App\Exceptions\JsonRpcExceptions;

use App\Exceptions\JsonRpcException;
use Throwable;

class InvalidParametersException extends JsonRpcException
{
    public function __construct($message = 'Invalid params', $code = self::INVALID_PARAMETERS_ERROR_CODE, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
