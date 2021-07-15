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
     * @return array The data pertaining to the authenticated user.
     *
     ***************************************************************************************************/
    public static function checkCredentials(array $credentials) {
        $user = new User();

        $user->findOne('email', $credentials['email']);

        if (count($user->getState()) !== 0) {
            $saltedPassword = hash($_ENV['HASH_ALGORITHM'], $_ENV['SALT_PHRASE'] . $credentials['password']);
            if ($user->compare('password', $saltedPassword)) {
                return $user->getState();
            }
        }
    }


    /****************************************************************************************************
     *
     * Function: Auth::attempt().
     * Purpose: Attempts to authenticate the user using the credentials they input.
     * Precondition: N/A.
     * Postcondition: If the credentials are valid, then the user is authenticated.
     *
     * @param array $credentials The credentials supplied by the user.
     *
     * @return bool True if the user is successfully authenticated, false otherwise.
     *
     ***************************************************************************************************/
    public static function attempt(array $credentials) {
        $user = self::checkCredentials($credentials);

        if (count($user) !== 0) {

            $_SESSION['user'] = [
                'username' => $user['username'],
                'email' => $user['email'],
                'signedInAt' => date(DATE_RFC2822)
            ];

            return true;
        } else {
            return false;
        }
    }

    /****************************************************************************************************
     *
     * Function: Auth::user().
     * Purpose: Retrieves the user information from the current session.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     * @return array The user information of the currently validated user, or an empty array if they are
     *               a guest.
     *
     ***************************************************************************************************/
    public static function user() {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        } else {
            print_r($_SESSION);
            return array();
        }
    }
}