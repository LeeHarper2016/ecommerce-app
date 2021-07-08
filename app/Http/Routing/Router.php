<?php

namespace App\Http\Routing;

use App\Http\Requests\Request;

class Router {
    // Stores a list of all routes in the router.
    private static array $routes;

    /****************************************************************************************************
     *
     * Function: Router.__construct().
     * Purpose: Acts as a default constructor for the Router class.
     * Precondition: N/A.
     * Postcondition: The Router object is initialized.
     *
     ***************************************************************************************************/
    public function __construct() {
        self::$routes = array();
    }

    /****************************************************************************************************
     *
     * Function: Router.get().
     * Purpose: Adds a GET route to the array of routes.
     * Precondition: N/A.
     * Postcondition: The route is added to the $routes array.
     *
     * @param string $uri The route that will execute a callback when resolved.
     * @param callable|array $callback The function/method that will be executed when the route is resolved.
     *
     ***************************************************************************************************/
    public static function get(string $uri, callable|array $callback) {
        self::$routes['get'][$uri] = $callback;
    }

    /****************************************************************************************************
     *
     * Function: Router::resolve().
     * Purpose: Resolves the current route, then executes a callback based on the route.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     * @param Request $request The information pertaining to the request.
     *
     ***************************************************************************************************/
    public static function resolve(Request $request) {
        $callback = self::$routes[$request->getMethod()][$request->getUri()] ?? false;

        if ($callback === false) {
            print("404: NOT FOUND");
            exit(404);
        } else {
            if (is_array($callback)) {
                $callable = [new $callback[0], $callback[1]];

                $callable();
            } else {
                $callback();
            }
        }
    }
}