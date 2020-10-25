<?php


namespace App\Exceptions;


use App\Http\JsonRpc\JsonRpcReponse;
use Illuminate\Http\JsonResponse;
use Throwable;

class JsonRpcErrorHandler extends Handler
{
    protected $rpcReponse;

    /**
     * JsonRpcErrorHandler constructor.
     *
     * @param JsonRpcReponse $rpcReponse
     */
    public function __construct(JsonRpcReponse $rpcReponse)
    {
        $this->rpcReponse = $rpcReponse;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param Throwable $exception
     * @param string|null $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function render($request, Throwable $exception, string $id = null): JsonResponse
    {
        if ($exception instanceof \JsonException) {
            $exception = new JsonRpcException('Parse error', JsonRpcException::PARSE_ERROR_CODE, $exception);
        }

        if (!$exception instanceof JsonRpcException) {
            $exception = new JsonRpcException('Internal error', JsonRpcException::INTERNAL_ERROR_CODE, $exception);
        }

        // @TODO доработать метод, чтобы принимал id для идентификации лога по id запроса.
        $this->report($exception);

        return $this->rpcReponse->makeErrorFromException($exception, $id);
    }
}
