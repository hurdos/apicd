<?php


namespace App\Exceptions\JsonRpcExceptions;

use App\Exceptions\JsonRpcException;
use Throwable;

class InvalidRequestException extends JsonRpcException
{
    public function __construct($message = "Invalid Request", $code = self::INVALID_REQUEST_ERROR_CODE, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
