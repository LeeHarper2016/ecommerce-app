<?php

use App\Http\Controllers\ProductController;
use App\Http\Routing\Router;

Router::get('/', function() {
    echo 'Hello world!';
});
Router::get('/product/{id}', [ProductController::class, 'view']);