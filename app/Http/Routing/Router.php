<?php

namespace App\Http\Routing;

use App\Http\Requests\Request;
use App\Http\Routing\Route;

class Router {
    // Stores a list of all routes in the router.
    private static array $routes;

    // If the requested route is not resolved, fallback to this route.
    private static array $fallback;

    /****************************************************************************************************
     *
     * Function: Router::addRoute().
     * Purpose: Adds a route to the router.
     * Precondition: N/A.
     * Postcondition: The route is added to the router.
     *
     * @param string $method The request method of the route.
     * @param string $uri The URI of the route.
     * @param callable|array The callback function that will be executed upon entering the route.
     *
     ***************************************************************************************************/
    private static function addRoute(string $method, string $uri, callable|array $callback) {
        preg_match('/{.+}/', $uri,$matches);

        if (count($matches) === 0) {
            self::$routes[] = ['route' => new Route($uri, $method),'callback' => $callback];
        } else {
            self::$routes[] = ['route' => new Route($uri, $method, $matches),'callback' => $callback];
        }
    }

    /****************************************************************************************************
     *
     * Function: Router::__construct().
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
     * Function: Router::get().
     * Purpose: Adds a GET route to the array of routes.
     * Precondition: N/A.
     * Postcondition: The route is added to the $routes array.
     *
     * @param string $uri The route that will execute a callback when resolved.
     * @param callable|array $callback The function/method that will be executed when the route is resolved.
     *
     ***************************************************************************************************/
    public static function get(string $uri, callable|array $callback) {
        self::addRoute('get', $uri, $callback);
    }

    /****************************************************************************************************
     *
     * Function: Router::post().
     * Purpose: Adds a POST route to the array of routes.
     * Precondition: N/A.
     * Postcondition: The route is added to the $routes array.
     *
     * @param string $uri The route that will execute a callback when resolved.
     * @param callable|array $callback The function/method that will be executed when the route is resolved.
     *
     ***************************************************************************************************/
    public static function post(string $uri, callable|array $callback) {
        self::addRoute('post', $uri, $callback);
    }

    /****************************************************************************************************
     *
     * Function: Router::put().
     * Purpose: Adds a PUT route to the array of routes.
     * Precondition: N/A.
     * Postcondition: The route is added to the $routes array.
     *
     * @param string $uri The route that will execute a callback when resolved.
     * @param callable|array $callback The function/method that will be executed when the route is resolved.
     *
     ***************************************************************************************************/
    public static function put(string $uri, callable|array $callback) {
        self::addRoute('patch', $uri, $callback);
    }

    /****************************************************************************************************
     *
     * Function: Router::patch().
     * Purpose: Adds a PATCH route to the array of routes.
     * Precondition: N/A.
     * Postcondition: The route is added to the $routes array.
     *
     * @param string $uri The route that will execute a callback when resolved.
     * @param callable|array $callback The function/method that will be executed when the route is resolved.
     *
     ***************************************************************************************************/
    public static function patch(string $uri, callable|array $callback) {
        self::addRoute('patch', $uri, $callback);
    }

    /****************************************************************************************************
     *
     * Function: Router::delete().
     * Purpose: Adds a DELETE route to the array of routes.
     * Precondition: N/A.
     * Postcondition: The route is added to the $routes array.
     *
     * @param string $uri The route that will execute a callback when resolved.
     * @param callable|array $callback The function/method that will be executed when the route is resolved.
     *
     ***************************************************************************************************/
    public static function delete(string $uri, callable|array $callback) {
        self::addRoute('delete', $uri, $callback);
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
        $routeFound = false;

        foreach (self::$routes as $route) {
            if ($route['route']->doesRouteMatch($request)) {
                $routeFound = true;

                $callback = $route['callback'];

                if (is_array($callback)) {
                    $callable = [new $callback[0], $callback[1]];

                    call_user_func_array($callable, $route['route']->getBoundInput());
                } else {
                    call_user_func_array($callback, $route['route']->getBoundInput());
                }
            }
        }

        if ($routeFound === false) {
            call_user_func_array(self::$fallback['callback'], self::$fallback['route']->getBoundInput());
        }
    }

    public static function fallback(string $uri, callable|array $callback) {
        self::$fallback = ['route' => new Route('get', $uri), 'callback' => $callback];
    }
}