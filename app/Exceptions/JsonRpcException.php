<?php


namespace App\Exceptions;

class JsonRpcException extends \Exception
{
    public const PARSE_ERROR_CODE = -32700;

    public const INTERNAL_ERROR_CODE = -32603;

    public const INVALID_REQUEST_ERROR_CODE = -32600;

    public const METHOD_NOT_FOUND_ERROR_CODE = -32601;

    public const INVALID_PARAMETERS_ERROR_CODE = -32602;
}
