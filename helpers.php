<?php

if (!function_exists('env')) {
    /**
     * Get environment var
     *
     * @param string $name
     * @return string|null
     */
    function env(string $name): ?string
    {
        if (!array_key_exists($name, $_ENV)) {
            return null;
        }

        return $_ENV[$name];
    }
}