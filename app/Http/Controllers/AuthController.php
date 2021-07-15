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

        Auth::checkCredentials(['email' => $request->getData()['email'], 'password' => $request->getData()['password']]);
    }
}