<?php

namespace App\Http\Routing;

class Router {
    // Stores a list of all routes in the router.
    private $routes;

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
     ***************************************************************************************************/
    public function get($uri, $callback) {
        $this->routes['get'][$uri] = $callback;
    }
}