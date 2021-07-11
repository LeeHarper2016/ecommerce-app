<?php

use App\Http\Controllers\ProductController;
use App\Http\Routing\Router;

Router::get('/', function() {
    echo 'Hello world!';
});
Router::get('/products/{id}', [ProductController::class, 'view']);
Router::post('/products', [ProductController::class, 'store']);