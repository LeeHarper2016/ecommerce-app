<?php

namespace App\Models;

use App\Database\DB;
use Exception;

abstract class Model {
    protected ?string $table = null;
    protected array $attributes = Array();
    protected array $state;

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
     * Function: Model.callAttributeModifier().
     * Purpose: Calls all of the necessary attribute modifiers for the model.
     * Precondition: N/A.
     * Postcondition: The attribute is supplied using the associated modifier.
     *
     ***************************************************************************************************/
    private function callAttributeModifier(string $attribute, mixed $value) {
        if (method_exists($this, "set${attribute}Attribute")) {
            call_user_func_array([$this, "set${attribute}Attribute"], ['value' => $value]);
        }
    }

    /****************************************************************************************************
     *
     * Function: Model.assignValueToAttribute().
     * Purpose: Assigns a value to the given attribute of the model.
     * Precondition: N/A.
     * Postcondition: The value is successfully stored to the attribute.
     *
     * @param mixed $value The value to be stored to the attribute.
     * @param string $attribute The attribute that the value will be stored to.
     *
     ***************************************************************************************************/
    private function assignValueToAttribute(mixed $value, string $attribute) {
        if (in_array($attribute, $this->attributes)) {
            $this->callAttributeModifier($attribute, $value);

            if (!isset($this->state[$attribute])) {
                $this->state[$attribute] = $value;
            }
        } else {
            echo 'ERROR: ATTRIBUTE NOT FOUND IN MODEL';
        }
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
     * Postcondition: The state of the model is updated.
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
     * Postcondition: The state of the model is updated.
     *
     * @param int $id The ID being used for the search.
     *
     ***************************************************************************************************/
    public function find(int $id) {
        $this->state = DB::query('SELECT * FROM ' . $this->table . ' WHERE id = :id', [':id' => $id]);
    }

    /****************************************************************************************************
     *
     * Function: Model.create().
     * Purpose: Creates a new database model supplied with data given by the user.
     * Precondition: N/A.
     * Postcondition: A new model is stored to the database and the models current state is updated.
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
                $columnString = implode(', ', array_keys($data));
                $options = array();

                foreach ($data as $key => $datum) {
                    $this->assignValueToAttribute($datum, $key);

                    $options[':' . $key] = $this->state[$key];
                }

                $valuesString = implode(',', array_keys($options));

                DB::query("INSERT INTO $this->table ($columnString) VALUES ($valuesString)", $options);
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
     * Postcondition: The selected model is updated.
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

                        $updateString .= "$key = :$key";

                        if ($i !== count($data) - 1) {
                            $updateString .= ', ';
                        }
                    }

                    $options = ['id' => $id] + $data;

                    DB::query("UPDATE $this->table SET $updateString WHERE id = :id", $options);

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
     * Postcondition: The model is deleted, and the state of this model is updated to reflect it's old data.
     *
     * @param int $id The ID of the model being deleted.
     * @throws Exception An exception is thrown if the attributes provided are not listed on the model.
     *
     ***************************************************************************************************/
    public function delete(int $id) {
        $this->find($id);

        if (count($this->state)) {
            DB::query("DELETE FROM $this->table WHERE id = :id", ['id' => $id]);
            return $this->state;
        } else {
            return array();
        }
    }

    /****************************************************************************************************
     *
     * Function: Model.findOne().
     * Purpose: Finds one model match from the database relating to a given attribute and variable.
     * Precondition: N/A.
     * Postcondition: The state is supplied with the found model
     *
     * @param string $attribute The attribute that is being searched with.
     * @param mixed $value The value of the attribute being searched for.
     *
     ***************************************************************************************************/
    public function findOne(string $attribute, mixed $value) {
        if ($this->checkAttributes([$attribute => ''])) {
            $this->state = DB::query("SELECT * FROM $this->table WHERE $attribute = :$attribute LIMIT 1", [":$attribute" => $value])[0];
        }
    }

    /****************************************************************************************************
     *
     * Function: Model.compare().
     * Purpose: Compares the attribute of a model to see if it is equal to a given value.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     * @param string $attribute The attribute being compared against.
     * @param mixed $value The value that is being compared to the model.
     *
     ***************************************************************************************************/
    public function compare(string $attribute, mixed $value) {
        if ($this->checkAttributes([$attribute => ''])) {
            return $this->state[$attribute] === $value;
        }
    }

    /****************************************************************************************************
     *
     * Function: Model.getState().
     * Purpose: Gets the current state of the model.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     * @return array The current state of the model.
     *
     ***************************************************************************************************/
    public function getState() {
        return $this->state;
    }
}