<?php

namespace App\Http\Routing;

use App\Http\Requests\Request;

class Route {
    private string $uri;
    private string $method;
    private ?array $bindings;
    private ?array $boundInput;

    public function __construct(string $uri, string $method, array $bindings = null) {
        $this->uri = $uri;
        $this->method = strtolower($method);
        $this->bindings = $bindings;
    }

    /****************************************************************************************************
     *
     * Function: Route.setBoundInput($input).
     * Purpose: Sets a new binding based on route parameters.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     * @param string $input The input retrieved from the requested route.
     * @param string $bind  The associated binding that the input is matched with.
     *
     ***************************************************************************************************/
    private function setBoundInput(string $input, string $bind) {
        $this->boundInput[$bind] = $input;
    }

    /****************************************************************************************************
     *
     * Function: Route.getUri().
     * Purpose: Gets the route string.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     * @return string The URI associated with the route.
     *
     ****************************************************************************************************/
    public function getUri() {
        return $this->uri;
    }

    /****************************************************************************************************
     *
     * Function: Route.getMethod().
     * Purpose: Gets the method of this route.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     * @return string The request method associated with this route.
     *
     ****************************************************************************************************/
    public function getMethod() {
        return $this->method;
    }

    /****************************************************************************************************
     *
     * Function: Route.getBindings().
     * Purpose: Gets the list of bindings that are associated with this route.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     * @return array The list of bindings associated with the route.
     *
     ****************************************************************************************************/
    public function getBindings() {
        return $this->bindings;
    }

    /****************************************************************************************************
     *
     * Function: Route.getBoundInput().
     * Purpose: Gets the bound inputs of the route.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     * @return array The bound inputs that are associated with the route.
     *
     ****************************************************************************************************/
    public function getBoundInput() {
        return $this->boundInput;
    }

    /****************************************************************************************************
     *
     * Function: Route.setBinding().
     * Purpose: Takes in user input, and then binds it to the appropriate binding.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     ****************************************************************************************************/
    public function setBinding(string $input, string $bind) {
        $this->setBoundInput($input, substr($bind, 1, -1));
    }

    /****************************************************************************************************
     *
     * Function: Route.doesRouteMatch().
     * Purpose: Checks to ensure that this route matches the route of a request. If it does, it also performs
     *          route parameter binding.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     * @return bool True if the routes match, false otherwise.
     *
     ****************************************************************************************************/
    public function doesRouteMatch(Request $request) {
        $requestArray = explode('/', $request->getUri());
        $routeArray = explode('/', $this->uri);

        if (count($requestArray) === count($routeArray)) {
            for($i = 0; $i < count($routeArray); $i++) {
                if (substr($routeArray[$i], 0, 1) === '{') {
                    $this->setBinding($requestArray[$i], $routeArray[$i]);
                } else {
                    if ($routeArray[$i] !== $requestArray[$i]) {
                        return false;
                    }
                }
            }
        } else {
            return false;
        }

        return true;
    }
}