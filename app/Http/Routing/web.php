<?php

use App\Http\Controllers\ProductController;
use App\Http\Routing\Router;

Router::get('/', function() {
    print(file_get_contents(__DIR__ . '/../../../public/index.html'));
});
Router::get('/api/products/{id}', [ProductController::class, 'view']);
Router::get('/api/products', [ProductController::class, 'viewAll']);
Router::post('/api/products', [ProductController::class, 'store']);
Router::patch('/api/products/{id}', [ProductController::class, 'update']);
Router::delete('/api/products/{id}', [ProductController::class, 'delete']);