<?php

namespace App\Models;

use App\Database\DB;
use Exception;

abstract class Model {
    protected ?string $table = null;
    protected array $attributes = Array();
    private array $state;

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

        if (count($this->attributes) === 0) {
            $this->attributes = DB::getTableColumns($this->table);
        }
    }

    /****************************************************************************************************
     *
     * Function: Model.getAll().
     * Purpose: Retrieves an array of all instances of the model recorded in the database.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     ***************************************************************************************************/
    public function getAll() {
        $this->state = DB::query('SELECT * FROM ' . $this->table);
    }

    /****************************************************************************************************
     *
     * Function: Model.find().
     * Purpose: Finds a model within the database that has a supplied id.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     * @param int $id The ID being used for the search.
     *
     ***************************************************************************************************/
    public function find(int $id) {
        $this->state = DB::query('SELECT * FROM ' . $this->table . ' WHERE id = :id', [':id' => $id]);
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
        try {
            if (!$this->checkAttributes($data)) {
                throw new Exception('The attributes provided do not match the attributes of the model.');
            } else {
                $columnString = '(' . implode(', ', array_keys($data)) . ')';
                $options = array();

                foreach ($data as $key => $datum) {
                    $options[':' . $key] = $datum;
                }

                $this->state = DB::query('INSERT INTO ' . $this->table . $columnString . '
            VALUES (' . implode(',', array_keys($options)) . ')', $options);
            }
        } catch (Exception $e) {
            echo 'ERROR: ' . $e->getMessage();
            exit();
        }
    }

    /****************************************************************************************************
     *
     * Function: Model.update().
     * Purpose: Updates a database model that is associated with the supplied $id.
     * Precondition: N/A.
     * Postcondition: The model is updated.
     *
     * @param array $data The data that will be used to update the model
     * @throws Exception An exception is thrown if the attributes provided are not listed on the model.
     *
     ***************************************************************************************************/
    public function update(int $id, array $data) {
        try {
            if (!$this->checkAttributes($data)) {
                throw new Exception('The attributes provided do not match the attributes of the model.');
            } else {
                $this->find($id);

                if (!is_null($this->state)) {
                    $updateString = "";

                    for ($i = 0; $i < count($data); $i++) {
                        $key = array_keys($data)[$i];

                        $updateString .= "{$key} = :{$key}";

                        if ($i !== count($data) - 1) {
                            $updateString .= ', ';
                        }
                    }

                    $options = ['id' => $id] + $data;

                    DB::query("UPDATE {$this->table} SET {$updateString} WHERE id = :id", $options);

                    $this->state = $options;
                }

            }
        } catch (Exception $e) {
            echo 'ERROR: ' . $e->getMessage();
            exit();
        }
    }

    /****************************************************************************************************
     *
     * Function: Model.delete().
     * Purpose: Deletes a database model that is associated with the supplied $id.
     * Precondition: N/A.
     * Postcondition: The model is deleted.
     *
     * @param int $id The ID of the model being deleted.
     * @throws Exception An exception is thrown if the attributes provided are not listed on the model.
     *
     ***************************************************************************************************/
    public function delete(int $id) {
        $this->find($id);

        if (count($this->state)) {
            DB::query("DELETE FROM {$this->table} WHERE id = :id", ['id' => $id]);
            return $this->state;
        }
    }

    /****************************************************************************************************
     *
     * Function: Model.getResult().
     * Purpose: Gets the current state of the model.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     * @return array The current state of the model.
     *
     ***************************************************************************************************/
    public function getResult() {
        return $this->state;
    }
}