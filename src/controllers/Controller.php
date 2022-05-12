<?php

namespace App\Controllers;

use JsonSerializable;

class Controller
{
    /**
     * Return json response.
     *
     * @param mixed $data
     * @param integer $status
     * @return string
     */
    protected function response(mixed $data, int $status = 200): string
    {
        http_response_code($status);

        return json_encode([
            'data' => $data,
            'status' => $status
        ]);
    }
}