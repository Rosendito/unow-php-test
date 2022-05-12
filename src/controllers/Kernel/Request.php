<?php

namespace App\Controllers\Kernel;

class Request
{
    /**
     * Init request
     */
    function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        $this->bootstrap();
    }

    /**
     * Bootstrap the request, adding all server env vars to
     * class
     *
     * @return void
     */
    protected function bootstrap(): void
    {
        foreach ($_SERVER as $key => $value) {
            $this->{$this->toCamelCase($key)} = $value;
        }
    }

    /**
     * Helper to transform string to camelcase
     *
     * @param string $string
     * @return void
     */
    protected function toCamelCase(string $string): string
    {
        $result = strtolower($string);

        preg_match_all('/_[a-z]/', $result, $matches);

        foreach ($matches[0] as $match) {
            $c = str_replace('_', '', strtoupper($match));
            $result = str_replace($match, $c, $result);
        }

        return $result;
    }

    /**
     * Get body from request
     *
     * @return array|null
     */
    public function getBody(): ?array
    {
        if ($this->requestMethod === "GET") {
            return null;
        }

        if ($this->requestMethod == "POST") {
            $body = [];
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(
                    INPUT_POST,
                    $key,
                    FILTER_SANITIZE_SPECIAL_CHARS
                );
            }

            return $body;
        }
    }

    /**
     * Get query from request
     *
     * @return array|null
     */
    public function getQuery(): ?array
    {
        $query = [];
        
        foreach ($_GET as $key => $value) {
            $query[$key] = filter_input(
                INPUT_GET,
                $key,
                FILTER_SANITIZE_SPECIAL_CHARS
            );
        }

        return $query;
    }
}
