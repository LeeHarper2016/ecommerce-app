<?php

namespace App\Database;

use PDO;
use PDOException;

class DB {
    // The PDO connection to the database.
    private static $connection;

    /**************************************************************************************************************
     *
     * Function: DB::initiate().
     * Purpose: Initiates the database connection using values from the env variable.
     * Precondition: N/A.
     * Postcondition: If valid data is supplied, a database connection is created.
     *
     *************************************************************************************************************/
    public static function initiate() {
        try {
            self::$connection = new PDO($_ENV['DATABASE_DSN'], $_ENV['DATABASE_USER'], $_ENV['DATABASE_PASSWORD']);
//            echo 'Successfully connected';
        } catch (PDOException $e) {
//            echo 'ERROR';
            die();
        }
    }

    /**************************************************************************************************************
     *
     * Function: DB::query().
     * Purpose: Performs a database query and returns the result.
     * Precondition: A database connection is established.
     * Postcondition: N/A.
     *
     * @param string $sql The SQL query to execute.
     * @param array|null $options The options that will be passed into the query.
     * @return array An array with all of the data obtained from the query.
     *
     *************************************************************************************************************/
    public static function query(string $sql, array $options = null) {
        $statement = self::$connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        if (!is_null($options)) {
            $statement->execute($options);
        } else {
            $statement->execute();
        }

        return $statement->fetchAll();
    }
}