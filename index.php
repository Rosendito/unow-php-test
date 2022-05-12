<?php

use App\Controllers\Kernel\Kernel;

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/helpers.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$httpKernel = new Kernel();
$httpKernel->register();
