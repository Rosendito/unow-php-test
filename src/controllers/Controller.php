<?php

namespace App\Controllers;

use JsonSerializable;

class Controller
{
    /**
     * Return json response.
     *
     * @param array $data
     * @param integer $status
     * @return string
     */
    protected function response(array $data, int $status = 200): string
    {
        return json_encode([
            'data' => $data,
            'status' => $status
        ]);
    }
}