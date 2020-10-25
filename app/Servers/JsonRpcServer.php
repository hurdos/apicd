<?php


namespace App\Servers;

use App\Exceptions\JsonRpcErrorHandler;
use App\Exceptions\JsonRpcExceptions\InvalidRequestException;
use App\Exceptions\JsonRpcExceptions\MethodNotFoundException;
use App\Http\JsonRpc\JsonRpcReponse;
use App\Http\JsonRpc\JsonRpcRouter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JsonRpcServer
{
    /**
     * @var JsonRpcRouter
     */
    protected $router;

    /**
     * @var JsonRpcReponse
     */
    protected $rpcReponse;

    protected $errorHandler;

    /**
     * JsonRpcServer constructor.
     * @param JsonRpcRouter $router
     * @param JsonRpcReponse $rpcReponse
     * @param JsonRpcErrorHandler $errorHandler
     */
    public function __construct(JsonRpcRouter $router, JsonRpcReponse $rpcReponse, JsonRpcErrorHandler $errorHandler)
    {
        $this->router = $router;
        $this->rpcReponse = $rpcReponse;
        $this->errorHandler = $errorHandler;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function handle(Request $request): JsonResponse
    {
        $id = null;
        try {
            $content = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

            $id = isset($content['id'] ) ? (string)$content['id'] : null;

            $version = $content['jsonrpc'] ?? '';
            if (JsonRpcReponse::VERSION !== $version) {
                throw new InvalidRequestException();
            }

            $methodName = isset($content['method']) ? (string)$content['method'] : '';
            if (!$methodName) {
                throw new InvalidRequestException();
            }

            if (!$this->router->isMethodAvailable($methodName)) {
                throw new MethodNotFoundException();
            }

            $params = $content['params'] ?? [];
            if (!is_array($params)) {
                throw new InvalidRequestException();
            }

            $result = $this->router->call($methodName, $params);
            return $this->rpcReponse->makeResult($result, $id);

        } catch (\Throwable $e) {
            return $this->errorHandler->render($request, $e, $id);
        }
    }
}
