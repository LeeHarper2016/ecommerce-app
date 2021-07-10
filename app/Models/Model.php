<?php

namespace App\Models;

use App\Database\DB;
use Exception;

abstract class Model {
    protected $table;
    protected $attributes;

    /****************************************************************************************************
     *
     * Function: Model.deriveTableFromClass().
     * Purpose: Retrieves the name of the class and returns it in all lower-case.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     * @return string The lower case form of the class name.
     *
     ***************************************************************************************************/
    private function deriveTableFromClass() {
        $classPath = explode('\\', static::class);

        return strtolower(end($classPath));
    }

    /****************************************************************************************************
     *
     * Function: Model.checkAttributes().
     * Purpose: Checks the keys of an array to ensure they match the attributes listed in the model.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     * @param array $data The data that was about to be parsed into the model.
     * @return bool A determination of if the keys of the array match the attributes of the model.
     *
     ***************************************************************************************************/
    private function checkAttributes(array $data) {
        foreach ($data as $key => $datum) {
            if (!in_array($key, $this->attributes)) {
                return false;
            }
        }

        return true;
    }

    /****************************************************************************************************
     *
     * Function: Model.__construct().
     * Purpose: Constructs a new model instance.
     * Precondition: N/A.
     * Postcondition: A new Model object is initialized.
     *
     ***************************************************************************************************/
    public function __construct() {
        if (is_null($this->table)) {
            $this->table = $this->deriveTableFromClass();
        }
    }

    /****************************************************************************************************
     *
     * Function: Model.getAll().
     * Purpose: Retrieves an array of all instances of the model recorded in the database.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     * @return array An array of all model instances.
     *
     ***************************************************************************************************/
    public function getAll() {
        return DB::query('SELECT * FROM ' . $this->table);
    }

    /****************************************************************************************************
     *
     * Function: Model.find().
     * Purpose: Finds a model within the database that has a supplied id.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     * @param int $id The ID being used for the search
     * @return array The model that has the supplied array, or an empty array if none was found.
     *
     ***************************************************************************************************/
    public function find(int $id) {
        $result = DB::query('SELECT * FROM ' . $this->table . ' WHERE id = :id', [':id' => $id]);

        if (count($result) === 0) {
            return array();
        } else {
            return $result[0];
        }
    }

    /****************************************************************************************************
     *
     * Function: Model.fill().
     * Purpose: Supplies the attributes of the model with data given by the user.
     * Precondition: N/A.
     * Postcondition: The $attributes are filled.
     *
     * @param array $data The data that will be used to populate the model
     * @throws Exception
     *
     ***************************************************************************************************/
    public function fill(array $data) {
        if (!$this->checkAttributes($data)) {
            throw new Exception('The attributes provided do not match the attributes of the model.');
        } else {
            foreach ($data as $key => $attribute) {
                $this->attributes[$key] = $attribute;
            }
        }
    }

    /****************************************************************************************************
     *
     * Function: Model.fill().
     * Purpose: Creates a new database model supplied with data given by the user.
     * Precondition: N/A.
     * Postcondition: A new model is stored to the database.
     *
     * @param array $data The data that will be used to create a new model
     * @throws Exception
     *
     ***************************************************************************************************/
    public function create(array $data) {
        if (!$this->checkAttributes($data)) {
            throw new Exception('The attributes provided do not match the attributes of the model.');
        } else {
            $columnString = '(' . implode(', ', array_keys($data)) . ')';
            $options = array();

            foreach ($data as $key => $datum) {
                $options[':' . $key] = $datum;
            }

            $result = DB::query('INSERT INTO ' . $this->table . $columnString . '
            VALUES (' . implode(',', array_keys($options)) . ')', $options);
        }

    }
}