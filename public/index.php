<?php

use Bootstrap\Application;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../bootstrap/Config.php';

// Load env vars
(new Dotenv())->loadEnv(__DIR__ . '/../.env');

// Routes...
require_once __DIR__ . '/../router/Api.php';

// Start app
(new Application());
