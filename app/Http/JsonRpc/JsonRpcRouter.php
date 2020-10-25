<?php


namespace App\Http\JsonRpc;

use App\Exceptions\JsonRpcExceptions\MethodNotFoundException;
use App\Http\JsonRpc\Controllers\PageController;

class JsonRpcRouter
{
    /**
     * methodName => Controller class
     * @var array
     */
    protected $methodList = [
        'addPage' => PageController::class,
        'getPageByUID' => PageController::class
    ];

    /**
     * @param string $methodName
     * @param array $params
     * @return array
     * @throws MethodNotFoundException
     */
    public function call(string $methodName, array $params): array
    {
        $controller = app($this->getClassNameByMethodName($methodName));
        if (!method_exists($controller, $methodName)) {
            throw new MethodNotFoundException();
        }

        return $controller->{$methodName}($params);
    }

    /**
     * @param string $methodName
     * @return string
     * @throws MethodNotFoundException
     */
    protected function getClassNameByMethodName(string $methodName): string
    {
        if (!$this->isMethodAvailable($methodName)) {
            throw new MethodNotFoundException();
        }
        return $this->methodList[$methodName];
    }

    /**
     * @param string $methodName
     * @return bool
     */
    public function isMethodAvailable(string $methodName): bool
    {
        return isset($this->methodList[$methodName]);
    }

    /**
     * @return array
     */
    public function getAvailableMethodList(): array
    {
        return array_keys($this->methodList);
    }
}
