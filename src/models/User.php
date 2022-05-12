<?php

namespace App\Models;

class User extends Model
{
    const ROLE_DOCTOR = 'doctor';
    const ROLE_PATIENT = 'patient';

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

    /**
     * Valide if the current user has that role
     *
     * @param string $role
     * @return boolean
     */
    public function validateRole(string $role): bool
    {
        return $this->role === $role;
    }
}