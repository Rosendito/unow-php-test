<?php

namespace App\Controllers\Kernel;

class Router
{
    /**
     * Incoming request.
     *
     * @var Request
     */
    protected Request $request;

    /**
     * Supported http methods
     *
     * @var array
     */
    private $supportedHttpMethods = [
        'GET',
        'POST',
        'PUT'
    ];

    /**
     * Init router.
     *
     * @param Request $request
     */
    function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Define all route as name[route] = handler
     *
     * @param string $name
     * @param string $args
     * @return void
     */
    function __call($name, $args): void
    {
        list($route, $method) = $args;

        if (!in_array(strtoupper($name), $this->supportedHttpMethods)) {
            $this->invalidMethodHandler();
        }

        $this->{strtolower($name)}[$this->formatRoute($route)] = $method;
    }

    /**
     * Format route.
     *
     * @param string $route
     * @return void
     */
    private function formatRoute(string $route): string
    {
        $result = rtrim(preg_replace('/\?.*/', '', $route), '/');

        if ($result === '') {
            return '/';
        }

        return $result;
    }

    /**
     * Dispatch exception when invalid method handler
     *
     * @return void
     */
    private function invalidMethodHandler(): void
    {
        header("{$this->request->serverProtocol} 405 Method Not Allowed");
    }

    /**
     * Dispatch exception when route not exists
     *
     * @return void
     */
    private function defaultRequestHandler(): void
    {
        header("{$this->request->serverProtocol} 404 Not Found");
    }

    /**
     * Resolves a route
     * 
     * @return void
     */
    function resolve(): void
    {
        $methodDictionary = $this->{strtolower($this->request->requestMethod)};
        $formatedRoute = $this->formatRoute($this->request->requestUri);

        if (!isset($methodDictionary[$formatedRoute])) {
            $this->defaultRequestHandler();
            return;
        }

        header('Content-Type: application/json; charset=utf-8');

        echo call_user_func_array($methodDictionary[$formatedRoute], array($this->request));
    }

    function __destruct()
    {
        $this->resolve();
    }
}
