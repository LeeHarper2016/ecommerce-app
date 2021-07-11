<?php

use App\Http\Controllers\ProductController;
use App\Http\Routing\Router;

Router::get('/', function() {
    print(file_get_contents(__DIR__ . '/../../../public/index.html'));
});
Router::get('/api/products/{id}', [ProductController::class, 'view']);
Router::post('/api/products', [ProductController::class, 'store']);