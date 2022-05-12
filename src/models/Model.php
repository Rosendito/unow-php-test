<?php

namespace App\Models;

use App\Models\Database\Database;

class Model
{
    /**
     * Table of the entity.
     *
     * @var string
     */
    protected string $table;

    /**
     * Attributes of the entity;
     *
     * @var array
     */
    protected array $attributes = [];

    /**
     * Data of the current entity.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Database instance.
     *
     * @var Database
     */
    protected Database $database;

    /**
     * Init new model.
     */
    public function __construct()
    {
        $this->database = new Database;
    }

    /**
     * Set getter for get attributes from data
     *
     * @param string $attribute
     * @return mixed
     */
    public function __get(string $attribute): mixed
    {
        if (array_key_exists($attribute, $this->data)) {
            return $this->data[$attribute];
        }

        return null;
    }

    /**
     * Fill data of the current entity.
     *
     * @param array $data
     * @return void
     */
    protected function fillData(array $data): void
    {
        foreach ($this->attributes as $attribute) {
            $this->data[$attribute] = array_key_exists($attribute, $data)
                ? $data[$attribute]
                : null;
        }
    }

    /**
     * Prepare data for only insert/update attributes declared
     * in the $attributes property
     *
     * @param array $data
     * @return array
     */
    public function prepareData(array $data): array
    {
        $preparedData = [];

        foreach ($data as $key => $value) {
            if (in_array($key, $this->attributes)) {
                $preparedData[$key] = $value;
            }
        }

        return $preparedData;
    }

    /**
     * Create new row model in database.
     *
     * @param array $data
     * @return self
     */
    public function create(array $data): self
    {
        $id = $this->database->insert($this->table, $data);
        $row = $this->findRow($id);

        $this->fillData($row);

        return $this;
    }

    /**
     * Find row in database by id
     *
     * @param integer $id
     * @return array
     */
    protected function findRow(int $id): array
    {
        return $this->database->select(
            table: $this->table,
            where: 'id = :id',
            whereValues: [
                'id' => $id
            ]
        )->get()[0];
    }
    
    /**
     * Find model entitiy by id
     *
     * @param integer $id
     * @return self
     */
    public function find(int $id): self
    {
        $row = $this->findRow($id);
        $this->fillData($row);

        return $this;
    }
}