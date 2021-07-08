<?php

namespace App;

use App\Http\Requests\Request;
use App\Http\Routing\Router;

require_once('Http/Routing/web.php');

class Application {
    public function run() {
        $request = new Request();

        Router::resolve($request);
    }
}