<?php

use App\Http\Routing\Router;

Router::get('/', function() {
    echo "Hello World!";
});