<?php

namespace App;

use App\Http\Requests\Request;
use App\Http\Routing\Router;
use App\Database\DB;
use Dotenv\Dotenv;

require_once('Http/Routing/web.php');

class Application {
    public function run() {
        $env = Dotenv::createImmutable('../');
        $env->load();

        DB::initiate();

        session_start();

        $request = new Request();

        Router::resolve($request);
    }
}