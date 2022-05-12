<?php

namespace App\Models;

class Date extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    /**
     * Table of the entity.
     *
     * @var string
     */
    protected string $table = 'dates';

    /**
     * Attributes of the entity;
     *
     * @var array
     */
    protected array $attributes = [
        'id',
        'patient_id',
        'note',
        'status',
        'updated_at',
        'created_at'
    ];
}