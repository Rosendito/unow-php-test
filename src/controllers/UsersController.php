<?php

namespace App\Controllers;

use App\Models\User;
use App\Controllers\Kernel\Request;

class UsersController extends Controller
{
    /**
     * List all users.
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request): string
    {
        $users = (new User)->all();

        return $this->response($users);
    }

    /**
     * Create user.
     *
     * @param Request $request
     * @return string
     */
    public function store(Request $request): string
    {
        $user = (new User)->create($request->getBody())->toArray();

        return $this->response($user);
    }
}