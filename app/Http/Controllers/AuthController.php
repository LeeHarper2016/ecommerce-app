<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
use App\Models\User;
use App\Services\Auth;

class AuthController {
    /****************************************************************************************************
     *
     * Function: AuthController.registerUser().
     * Purpose: Registers a user using data supplied by them.
     * Precondition: N/A.
     * Postcondition: A new user is saved to the database.
     *
     ***************************************************************************************************/
    public function registerUser() {
        $request = new Request();
        $user = new User();

        $user->create($request->getData());
    }

    /****************************************************************************************************
     *
     * Function: AuthController.logInUser().
     * Purpose: Attempts to log in a user.
     * Precondition: N/A.
     * Postcondition: Assuming they input the correct credentials, the user is logged in.
     *
     ***************************************************************************************************/
    public function logInUser() {
        $request = new Request();

        Auth::attempt(['email' => $request->getData()['email'], 'password' => $request->getData()['password']]);

        if (isset($_SESSION['user'])); {
            echo json_encode($_SESSION['user']);
        }
    }

    /****************************************************************************************************
     *
     * Function: AuthController.getUser().
     * Purpose: Prints the information of the currently authenticated user.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     ***************************************************************************************************/
    public function getUser() {
        echo json_encode(Auth::user());
    }

    /****************************************************************************************************
     *
     * Function: AuthController.getUser().
     * Purpose: Prints the information of the currently authenticated user.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     ***************************************************************************************************/
    public function getRole() {
        echo json_encode(['isOwner' => Auth::isUserOwner()]);
    }
}