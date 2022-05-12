<?php

use App\Models\Database\Database;

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/helpers.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$database = new Database();