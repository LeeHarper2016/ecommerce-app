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
        $statement = self::$connection->prepare($sql);

        if (!is_null($options)) {
            foreach ($options as $key => $option) {
                $statement->bindValue($key, $option);
            }
        }

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**************************************************************************************************************
     *
     * Function: DB::getTableColumns().
     * Purpose: Retrieves an array of columns associated with a table.
     * Precondition: The database connection exists.
     * Postcondition: N/A.
     *
     * @param string $table The table that is holding the columns.
     * @param bool $include_id Tells the function whether or not to include the ID. By default, this is false.
     * @return array An array with all of the requested columns of a table.
     *
     *************************************************************************************************************/
    public static function getTableColumns(string $table, bool $include_id = false) {
        $columns = Array();

        $tableQuery = self::$connection->query("SELECT * FROM {$table} LIMIT 0");

        for ($i = 0; $i < $tableQuery->columnCount(); $i++) {
            $column = $tableQuery->getColumnMeta($i);

            if ($include_id === true || $column['name'] !== 'id') {
                $columns[] = $column['name'];
            }
        }

        return $columns;
    }
}