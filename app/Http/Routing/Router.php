<?php

namespace App\Http\Routing;

class Router {
    // Stores a list of all routes in the router.
    private array $routes;

    /****************************************************************************************************
     *
     * Function: Router.__construct().
     * Purpose: Acts as a default constructor for the Router class.
     * Precondition: N/A.
     * Postcondition: The Router object is initialized.
     *
     ***************************************************************************************************/
    public function __construct() {
        $this->routes = array();
    }

    /****************************************************************************************************
     *
     * Function: Router.get().
     * Purpose: Adds a GET route to the array of routes.
     * Precondition: N/A.
     * Postcondition: The route is added to the $routes array.
     *
     * @param string $uri The route that will execute a callback when resolved.
     * @param callable $callback The function that will be executed when the route is resolved.
     *
     ***************************************************************************************************/
    public function get(string $uri, callable $callback) {
        $this->routes['get'][$uri] = $callback;
    }
}