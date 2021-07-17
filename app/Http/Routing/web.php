<?php

use App\Http\Controllers\AuthController;
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

Router::get('/api/user', [AuthController::class, 'getUser']);
Router::post('/api/user/login', [AuthController::class, 'logInUser']);

Router::get('/api/auth', [AuthController::class, 'getRole']);

Router::fallback('/',  function() {
    print(file_get_contents(__DIR__ . '/../../../public/index.html'));
});