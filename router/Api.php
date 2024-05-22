<?php

use Bootstrap\Router;
use App\Controllers\OrderController;
use App\Controllers\ProductController;
use App\Controllers\ProductTypeController;

// points
$productController = ProductController::class;
$productTypeController = ProductTypeController::class;
$OrderController = OrderController::class;

// Routes
Router::get('/produtos', "$productController@list");
Router::get('/produtos/(\d+)', "$productController@show");
Router::post('/produtos', "$productController@store");
Router::get('/tipos', "$productTypeController@list");
Router::get('/tipos/(\d+)', "$productTypeController@show");
Router::post('/tipos', "$productTypeController@store");
Router::post('/pedidos', "$OrderController@store");
Router::get('/pedidos', "$OrderController@list");
