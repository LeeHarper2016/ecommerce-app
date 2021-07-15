<?php

namespace App\Models;

class User extends Model {


    /****************************************************************************************************
     *
     * Function: User.setPasswordAttribute().
     * Purpose: Acts as an attribute modifier for the "password" attribute.
     * Precondition: N/A.
     * Postcondition: The mutated password is saved to the state of the model.
     *
     * @param string $value The plain-text password to be hashed, salted, and stored.
     *
     ***************************************************************************************************/
    public function setPasswordAttribute(string $value) {
        $this->state['password'] = hash($_ENV['HASH_ALGORITHM'], $_ENV['SALT_PHRASE'] . $value);
    }
}