<?php

namespace SelfPhp;

use SelfPhp\database\Database; 
use SelfPhp\SP;

class Serve
{

    public $db_connection;
    public $table;

    public function __construct($table)
    {
        $this->table = $table;
        $this->db_connection = new Database();
        $this->db_connection = $this->db_connection->connect();
    }

    /**
     * Saving of the post object is done here. 
     * 
     * An sql post request is executed on this function.
     * extract keys passed on the post object.
     * extract key values passed on the post object 
     * DB Query(INSERT)
     * 
     * @param post_object a post object that is passed as a parameter for 
     *                      execution by the sql post request
     * 
     * @author Giceha Junior <https://github.com/Gicehajunior>
     * @return bool 
     */
    public function save(array $post_object)
    {
        $table_column_keys = array_keys($post_object);

        $table_column_keys = implode(", ", $table_column_keys);

        $key_values = array_values($post_object);

        $key_values = implode("', '", str_replace("'", "`", $key_values));

        $query = "INSERT INTO $this->table($table_column_keys) VALUES('$key_values')";
        $result = mysqli_query($this->db_connection, $query); 

        if ($result == true or is_object($result) or is_object($result)) {
            return true;
        } else {
            SP::init_sql_debug($this->db_connection);
            return false;
        } 
    }

    /**
     * Function to fecth every row from a specified table.
     * 
     * @author Giceha Junior <https://github.com/Gicehajunior>
     * 
     * @return row_array - an array of rows fetched.
     * @return false - if an error and if debug is set to true, then,
     *                  a debug error will be returned.
     */
    public function fetchAll()
    {
        $query = "SELECT * FROM $this->table";
        $result = mysqli_query($this->db_connection, $query);

        if ($result == true or is_object($result)) {
            $row_array = array();

            while($rows = mysqli_fetch_assoc($result)){
                array_push($row_array, $rows);
            }

            return $row_array;
        } else {
            SP::init_sql_debug($this->db_connection);
            return false;
        } 
    }

    /**
     * Function to fecth every row from a specified table in descending
     * Order.
     * 
     * @author Giceha Junior <https://github.com/Gicehajunior>
     * 
     * @return row_array - an array of rows fetched.
     * @return false - if an error and if debug is set to true, then,
     *                  a debug error will be returned.
     */
    public function fetchAllInDescOrder() {
        $query = "SELECT * FROM $this->table ORDER BY $this->table.created_at DESC";
        $result = mysqli_query($this->db_connection, $query);

        if ($result == true or is_object($result)) {
            $row_array = array();

            while($rows = mysqli_fetch_assoc($result)){
                array_push($row_array, $rows);
            }

            return $row_array;
        } else {
            SP::init_sql_debug($this->db_connection);
            return false;
        } 
    }

    /**
     * Function to fecth every row from a specified table in ascending
     * Order.
     * 
     * @author Giceha Junior <https://github.com/Gicehajunior>
     * 
     * @return row_array - an array of rows fetched.
     * @return false - if an error and if debug is set to true, then,
     *                  a debug error will be returned.
     */
    public function fetchAllInAscOrder() {
        $query = "SELECT * FROM $this->table ORDER BY $this->table.created_at ASC";
        $result = mysqli_query($this->db_connection, $query);

        if ($result == true or is_object($result)) {
            $row_array = array();

            while($rows = mysqli_fetch_assoc($result)){
                array_push($row_array, $rows);
            }

            return $row_array;
        } else {
            SP::init_sql_debug($this->db_connection);
            return false;
        } 
    }

    /**
     * Function to fecth every row from a specified table based on a specified
     * unique row's primary key id.
     * 
     * @author Giceha Junior <https://github.com/Gicehajunior>
     * 
     * @return row - an array of rows fetched.
     * @return false - if an error and if debug is set to true, then,
     *                  a debug error will be returned.
     */
    public function FetchBasedOnId(int $id) {
        $query = "SELECT * FROM $this->table WHERE id='" . $id . "'";
        $result = mysqli_query($this->db_connection, $query); 

        if ($result == true or is_object($result)) {
            $row = mysqli_fetch_assoc($result);

            if ($row) {
                return $row;
            }
        } else {
            SP::init_sql_debug($this->db_connection); 
            return false;
        } 
    }

    /**
     * Function to fecth every row from a specified table based on an email
     * 
     * @author Giceha Junior <https://github.com/Gicehajunior>
     * 
     * @return true - if the row exists, true status, is returned.
     * @return false - if an error and if debug is set to true, then,
     *                  a debug error will be returned.
     */
    public function user_exists_on_condition(array $post_object = [])
    {
        $exists = false;

        $query = "SELECT * FROM $this->table WHERE email='" . $post_object['email'] . "'";
        $result = mysqli_query($this->db_connection, $query);

        if ($result == true or is_object($result)) {
            $row_count = mysqli_num_rows($result);

            if ($row_count > 0) {
                $exists = true;

                return $exists;
            } else {
                return $exists;
            }
        } else {
            SP::init_sql_debug($this->db_connection);
            return false;
        } 
    }

    /**
     * Function to fecth row from a specified table based on an email
     * 
     * @author Giceha Junior <https://github.com/Gicehajunior>
     * 
     * @return row - Return row found.
     * @return false - if an error and if debug is set to true, then,
     *                  a debug error will be returned.
     */
    public function get_user_on_condition(array $post_object = [])
    {
        $query = "SELECT * FROM $this->table WHERE email='" . $post_object['email'] . "'";
        $result = mysqli_query($this->db_connection, $query); 

        if ($result == true or is_object($result)) {
            $row = mysqli_fetch_assoc($result);

            if ($row) {
                return $row;
            }
        } else {
            SP::init_sql_debug($this->db_connection); 
            return false;
        } 
    }

    /**
     * Deletes a row based on an id.
     * 
     * @author Giceha Junior <https://github.com/Gicehajunior>
     *  
     * @return bool - if an error and if debug is set to true, then,
     *                  a debug error will be returned. However, if no error, 
     *                  a true status is returned.
     */
    public function TrashBasedOnId(int $id) {
        $query = "DELETE FROM $this->table WHERE id ='" . $id . "'";
        $result = mysqli_query($this->db_connection, $query); 

        if ($result) {
            return true;
        } else {
            SP::init_sql_debug($this->db_connection); 
            return false;
        } 
    }


}
