<?php

namespace App\Controllers\Kernel;

class Kernel
{
    /**
     * Init kernel.
     */
    public function __construct()
    {
        $this->router = new Router(new Request);
    }

    /**
     * Register all routes.
     *
     * @return void
     */
    public function register(): void
    {
        $this->router->get('/api/test', function (Request $request) {
            echo 'Hola Mundo';
        });
    }
}