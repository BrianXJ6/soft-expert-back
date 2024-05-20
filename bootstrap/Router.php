<?php

namespace Bootstrap;

class Router
{
    /**
     * Routes
     *
     * @var array
     */
    protected static $routes = [];

    /**
     * Add GET route
     *
     * @param string $uri
     * @param string $action
     *
     * @return void
     */
    public static function get(string $uri, string $action): void
    {
        self::$routes['GET'][$uri] = $action;
    }

    /**
     * Add POST route
     *
     * @param string $uri
     * @param string $action
     *
     * @return void
     */
    public static function post(string $uri, string $action): void
    {
        self::$routes['POST'][$uri] = $action;
    }

    /**
     * Add PUT route
     *
     * @param string $uri
     * @param string $action
     *
     * @return void
     */
    public static function put(string $uri, string $action): void
    {
        self::$routes['PUT'][$uri] = $action;
    }

    /**
     * Add DELETE route
     *
     * @param string $uri
     * @param string $action
     *
     * @return void
     */
    public static function delete(string $uri, string $action): void
    {
        self::$routes['DELETE'][$uri] = $action;
    }

    /**
     * Dispatch route
     *
     * @param string $uri
     * @param string $method
     *
     * @return void
     */
    public static function dispatch(string $uri, string $method): void
    {
        foreach (self::$routes[$method] as $route => $action) {
            if (preg_match('#^' . $route . '$#', $uri, $matches)) {
                // Encontrou uma rota correspondente
                array_shift($matches); // Remove o primeiro elemento (a URL completa)
                $action = self::$routes[$method][$route];
                [$controller, $method] = explode('@', $action);
                // Execute a função do controlador associada à rota, passando os parâmetros
                call_user_func_array([new $controller(), $method], $matches);
                return;
            }
        }

        // Rota não encontrada
        echo "Route not found.";
    }
}
