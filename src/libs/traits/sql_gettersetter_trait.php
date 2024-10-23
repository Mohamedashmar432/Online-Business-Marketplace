<?php


/**
 * To use this trait, the PHP Object's constructor should have
 * $id, $conn, $tabel variables set.
 *
 * $id - The ID of the MySQL Table Row.
 * $conn - The MySQL Connection.
 * $table - The MySQL Table Name.
 */
trait SQLGetterSetter
{
    public function __call($name, $arguments)
    {
        $property = preg_replace("/[^0-9a-zA-Z]/", "", substr($name, 3));
        $property = strtolower(preg_replace('/\B([A-Z])/', '_$1', $property));

        if (substr($name, 0, 3) == "get") {
            return $this->_get_data($property);
        } elseif (substr($name, 0, 3) == "set") {
            // Check if multiple properties are being set
            if (is_array($arguments[0])) {
                return $this->_set_data_bulk($arguments[0]);
            } else {
                return $this->_set_data($property, $arguments[0]);
            }
        } else {
            throw new Exception(__CLASS__ . "::__call() -> $name, function unavailable.");
        }
    }

    // Fetch data from the database for a single column
    public function _get_data($var)
    {
        if (!$this->conn) {
            $this->conn = Database::getConnection();
        }
        try {
            $sql = "SELECT `$var` FROM `$this->table` WHERE `id` = '$this->id'";
            $result = $this->conn->query($sql);
            if ($result && $result->num_rows == 1) {
                return $result->fetch_assoc()["$var"];
            }
        } catch (Exception $e) {
            throw new Exception(__CLASS__ . "::_get_data() -> $var, data unavailable.");
        }
        return null; // Return null if nothing is found
    }
    

    // Set data for a single property
    public function _set_data($var, $data)
    {
        if (!$this->conn) {
            $this->conn = Database::getConnection();
        }
        try {
            $sql = "UPDATE `$this->table` SET `$var`='$data' WHERE `id`='$this->id';";
            if ($this->conn->query($sql)) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw new Exception(__CLASS__ . "::_set_data() -> $var, data unavailable.");
        }
    }

    // Set data for multiple properties in one call
    public function _set_data_bulk($data)
    {
        if (!$this->conn) {
            $this->conn = Database::getConnection();
        }
        try {
            $setValues = [];
            foreach ($data as $column => $value) {
                $column = strtolower(preg_replace('/\B([A-Z])/', '_$1', $column)); // Convert camelCase to snake_case
                $setValues[] = "`$column`='$value'";
            }

            $sql = "UPDATE `$this->table` SET " . implode(', ', $setValues) . " WHERE `id`='$this->id';";
            if ($this->conn->query($sql)) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw new Exception(__CLASS__ . "::_set_data_bulk() -> data unavailable.");
        }
    }
    public function delete()
    {
        if (!$this->conn) {
            $this->conn = Database::getConnection();
        }
        try {
            //TODO: Delete the image before deleting the post entry
            $sql = "DELETE FROM `$this->table` WHERE `id`=$this->id;";
            if ($this->conn->query($sql)) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw new Exception(__CLASS__ . "::delete, data unavailable.");
        }
    }

    public function getID()
    {
        return $this->id;
    }
}
