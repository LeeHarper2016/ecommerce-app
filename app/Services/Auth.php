<?php

namespace App\Services;

use App\Models\User;

class Auth {
    /****************************************************************************************************
     *
     * Function: Auth::checkCredentials().
     * Purpose: Checks the credentials against users found in the database.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     * @param array $credentials The credentials the user is attempting to log in with.
     *
     ***************************************************************************************************/
    public static function checkCredentials(array $credentials) {
        $user = new User();

        $user->findOne('email', $credentials['email']);

        if (count($user->getState()) !== 0) {
            $saltedPassword = hash($_ENV['HASH_ALGORITHM'], $_ENV['SALT_PHRASE'] . $credentials['password']);
            if ($user->compare('password', $saltedPassword)) {
                echo 'SUCCESSFULLY LOGGED IN.';
            }
        }
    }
}