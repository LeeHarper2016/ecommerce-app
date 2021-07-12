<?php

namespace App\Http\Routing;

use App\Http\Requests\Request;
use App\Http\Routing\Route;

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
        preg_match('/{.+}/', $uri,$matches);

        if (count($matches) === 0) {
            self::$routes[] = ['route' => new Route($uri, 'get'),'callback' => $callback];
        } else {
            self::$routes[] = ['route' => new Route($uri, 'get', $matches),'callback' => $callback];
        }
    }

    /****************************************************************************************************
     *
     * Function: Router.post().
     * Purpose: Adds a POST route to the array of routes.
     * Precondition: N/A.
     * Postcondition: The route is added to the $routes array.
     *
     * @param string $uri The route that will execute a callback when resolved.
     * @param callable|array $callback The function/method that will be executed when the route is resolved.
     *
     ***************************************************************************************************/
    public static function post(string $uri, callable|array $callback) {
        preg_match('/{.+}/', $uri,$matches);

        if (count($matches) === 0) {
            self::$routes[] = ['route' => new Route($uri, 'post'),'callback' => $callback];
        } else {
            self::$routes[] = ['route' => new Route($uri, 'post', $matches),'callback' => $callback];
        }
    }

    /****************************************************************************************************
     *
     * Function: Router.patch().
     * Purpose: Adds a PATCH route to the array of routes.
     * Precondition: N/A.
     * Postcondition: The route is added to the $routes array.
     *
     * @param string $uri The route that will execute a callback when resolved.
     * @param callable|array $callback The function/method that will be executed when the route is resolved.
     *
     ***************************************************************************************************/
    public static function patch(string $uri, callable|array $callback) {
        preg_match('/{.+}/', $uri,$matches);

        if (count($matches) === 0) {
            self::$routes[] = ['route' => new Route($uri, 'patch'),'callback' => $callback];
        } else {
            self::$routes[] = ['route' => new Route($uri, 'patch', $matches),'callback' => $callback];
        }
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
        foreach (self::$routes as $route) {
            if ($route['route']->doesRouteMatch($request)) {
                $callback = $route['callback'];

                if (is_array($callback)) {
                    $callable = [new $callback[0], $callback[1]];

                    print_r($route['route']->getBoundInput());

                    call_user_func_array($callable, $route['route']->getBoundInput());
                } else {
                    call_user_func_array($callback, $route['route']->getBoundInput());
                }
            }
        }
    }
}