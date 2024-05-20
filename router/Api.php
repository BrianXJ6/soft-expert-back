<?php

use Bootstrap\Router;
use App\Controllers\ProductController;

Router::get('/produtos', ProductController::class . '@list');
Router::get('/produtos/(\d+)', ProductController::class . '@show');
