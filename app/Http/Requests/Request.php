<?php

namespace App\Http\Requests;

class Request {
    // The route of the request.
    private string $uri;
    // The method of the request.
    private string $method;
    // The data of the request.
    private array $data;

    /****************************************************************************************************
     *
     * Function: Request.__construct()
     * Purpose: Initializes a new Request object.
     * Precondition: N/A.
     * Postcondition: The request object is initialized.
     *
     ****************************************************************************************************/
    public function __construct() {
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        $this->data = array();

        if (!is_null($_POST)) {
            $this->data = $_POST;
        } else if (!is_null($_GET)) {
            $this->data = $_GET;
        } else if (!is_null(file_get_contents('php://input'))) {
            $formData = file_get_contents('php://input');

            if ($formData !== "") {
                $this->data = json_decode($formData, true);
            }
        }
    }

    /****************************************************************************************************
     *
     * Function: Request.getUri().
     * Purpose: Retrieves the route that the request was accessed from.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     ****************************************************************************************************/
    public function getUri() {
        return $this->uri;
    }

    /****************************************************************************************************
     *
     * Function: Request.getMethod().
     * Purpose: Retrieves the request method that was used on the route.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     ****************************************************************************************************/
    public function getMethod() {
        return $this->method;
    }

    /****************************************************************************************************
     *
     * Function: Request.getData().
     * Purpose: Retrieves the data that was stored within the request.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     ****************************************************************************************************/
    public function getData() {
        return $this->data;
    }
}