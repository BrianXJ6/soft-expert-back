<?php

use Bootstrap\Router;
use App\Controllers\ProductController;

// points
$productController = ProductController::class;

// Routes
Router::get('/produtos', "$productController@list");
Router::get('/produtos/(\d+)', "$productController@show");
Router::post('/produtos', "$productController@store");
