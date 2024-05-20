<?php

namespace Bootstrap;

class Application
{
    /**
     * Create a new Application instance
     */
    public function __construct()
    {
        $this->bootstrapRouter();
    }

    /**
     * Router instance.
     *
     * @return void
     */
    public function bootstrapRouter(): void
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        Router::dispatch($uri, $method);
    }
}
