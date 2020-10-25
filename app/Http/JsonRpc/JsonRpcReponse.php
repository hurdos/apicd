<?php


namespace App\Http\JsonRpc;

use Illuminate\Http\JsonResponse;

class JsonRpcReponse
{
    public const VERSION = '2.0';

    /**
     * @param array $result
     * @param string $id
     * @return JsonResponse
     */
    public function makeResult(array $result, string $id): JsonResponse
    {
        return new JsonResponse([
            'jsonrpc' => self::VERSION,
            'result' => $result,
            'id' => $id,
        ]);
    }

    /**
     * @param string $message
     * @param int $code
     * @param string|null $id
     * @return JsonResponse
     */
    public function makeError(string $message = '', int $code = 0, string $id = null): JsonResponse
    {
        return new JsonResponse([
            'jsonrpc' => self::VERSION,
            'error' => [
                'code' => $code,
                'message' => $message,
            ],
            'id' => $id,
        ]);
    }

    /**
     * @param \Throwable $exception
     * @param string|null $id
     * @return JsonResponse
     */
    public function makeErrorFromException(\Throwable $exception, string $id = null): JsonResponse
    {
        return $this->makeError($exception->getMessage(), $exception->getCode(), $id);
    }
}
