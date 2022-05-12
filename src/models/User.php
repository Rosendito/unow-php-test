<?php

namespace App\Models;

class User extends Model
{
    /**
     * Table of the entity.
     *
     * @var string
     */
    protected string $table = 'users';

    /**
     * Attributes of the entity;
     *
     * @var array
     */
    protected array $attributes = [
        'id',
        'name',
        'email',
        'role',
        'updated_at',
        'created_at'
    ];
}