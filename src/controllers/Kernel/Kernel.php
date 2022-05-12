<?php

namespace App\Controllers\Kernel;

use App\Controllers\UsersController;

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
        $usersController = new UsersController();

        $this->router->get('/', fn() => 'Hello world!');

        $this->router->get('/api/users', fn(Request $request) =>
            $usersController->index($request)
        );

        $this->router->post('/api/users', fn(Request $request) =>
            $usersController->store($request)
        );
    }
}