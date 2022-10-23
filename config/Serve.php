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
        try {
            $table_column_keys = array_keys($post_object);

            $new_table_column_keys = [];
            foreach ($table_column_keys as $key => $value) {
                array_push($new_table_column_keys, "`$value`");
            }
            
            $table_column_keys = $new_table_column_keys;
            $table_column_keys = implode(", ", $table_column_keys);  

            $key_values = array_values($post_object);

            $new_key_values = array();
            foreach ($key_values as $key => $value) {
                array_push($new_key_values, str_replace("'", "`", $value));
            }

            $key_values = $new_key_values; 

            $key_values = implode("', '", $key_values);

            $query = "INSERT INTO $this->table($table_column_keys) VALUES('$key_values')";
            $result = mysqli_query($this->db_connection, $query); 

            if ($result == true or is_object($result)) {
                return true;
            } else { 
                return false;
            }
        } catch (\Throwable $error) {
            SP::debug_backtrace_show($error);
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
        try {
            $query = "SELECT * FROM $this->table";
            $result = mysqli_query($this->db_connection, $query);

            $row_array = array();
            
            if ($result == true or is_object($result)) {
                while($rows = mysqli_fetch_assoc($result)){
                    array_push($row_array, $rows);
                } 
            }

            return $row_array[0];
        } catch (\Throwable $error) {
            SP::debug_backtrace_show($error); 
        }
    }

    /**
     * Function to fecth every row from a specified table in descending
     * Order while ordered by creation time.
     * 
     * @author Giceha Junior <https://github.com/Gicehajunior>
     * 
     * @return row_array - an array of rows fetched.
     * @return false - if an error and if debug is set to true, then,
     *                  a debug error will be returned.
     */
    public function fetchAllInDescOrder() {
        try {
            $query = "SELECT * FROM $this->table ORDER BY $this->table.created_at DESC";
            $result = mysqli_query($this->db_connection, $query);

            $row_array = array();

            if ($result == true or is_object($result)) { 

                while($rows = mysqli_fetch_assoc($result)){
                    array_push($row_array, $rows);
                }
            }

            return $row_array[0];
        } catch (\Throwable $error) {
            SP::debug_backtrace_show($error); 
        } 
    }

    /**
     * Function to fecth every row from a specified table in ascending
     * Order while ordered by creation time.
     * 
     * @author Giceha Junior <https://github.com/Gicehajunior>
     * 
     * @return row_array - an array of rows fetched.
     * @return false - if an error and if debug is set to true, then,
     *                  a debug error will be returned.
     */
    public function fetchAllInAscOrder() {
        try {
            $query = "SELECT * FROM $this->table ORDER BY $this->table.created_at ASC";
            $result = mysqli_query($this->db_connection, $query);

            $row_array = array();

            if ($result == true or is_object($result)) { 

                while($rows = mysqli_fetch_assoc($result)){
                    array_push($row_array, $rows);
                }
            }

            return $row_array[0];
        } catch (\Throwable $error) {
            SP::debug_backtrace_show($error); 
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
        try {
            $row = array();

            $query = "SELECT * FROM $this->table WHERE id='" . $id . "'";
            $result = mysqli_query($this->db_connection, $query); 

            if ($result == true or is_object($result)) {
                $row = mysqli_fetch_assoc($result);
            }

            return $row;
        } catch (\Throwable $error) {
            SP::debug_backtrace_show($error); 
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

        try {
            $query = "SELECT * FROM $this->table WHERE email='" . $post_object['email'] . "'";
            $result = mysqli_query($this->db_connection, $query);
            
            $row_count = mysqli_num_rows($result);

            if ($row_count > 0) {
                $exists = true;

                return $exists;
            } else {
                return $exists;
            }
        } catch (\Throwable $error) {
            SP::debug_backtrace_show($error); 
        }  
    }

    /**
     * Function to fecth every row from a specified table based on an passed params
     * 
     * @author Giceha Junior <https://github.com/Gicehajunior>
     * 
     * @return rows
     */
    public function query_by_condition(array $post_object = [])
    {  
        try {
            $appendable_query_string = null;

            $post = $post_object;
            foreach ($post as $key => $value) {
                if (!empty($value)) {
                    $command = $key . ' ' . '"' . $value . '"';
                    $appendable_query_string .= $command;
                } 
            } 

            $query = "SELECT * FROM $this->table WHERE " . $appendable_query_string; 
            $result = mysqli_query($this->db_connection, $query);
            
            $row_array = array();

            if ($result) {
                while($rows = mysqli_fetch_assoc($result)){
                    array_push($row_array, $rows);
                }
            }
            return $row_array; 
        } catch (\Throwable $error) {
            SP::debug_backtrace_show($error);  
        }
    }

    /**
     * Function to fecth row from a specified table based on an email
     * 
     * @author Giceha Junior <https://github.com/Gicehajunior>
     * 
     * @return row - Return row found.
     * if an error and if debug is set to true, then,
     * a debug error will be returned.
     */
    public function get_user_on_condition(array $post_object = [])
    { 
        try {
            $query = "SELECT * FROM $this->table WHERE email='" . $post_object['email'] . "'";
            $result = mysqli_query($this->db_connection, $query); 

            $row_array = array();

            if ($result) {
                while($rows = mysqli_fetch_assoc($result)){
                    array_push($row_array, $rows);
                }
            }

            return $row_array[0]; 
        } catch (\Throwable $error) {
            SP::debug_backtrace_show($error);  
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
        try {
            $query = "DELETE FROM $this->table WHERE id ='" . $id . "'";
            $result = mysqli_query($this->db_connection, $query); 

            if ($result) {
                return true;
            } else { 
                return false;
            }
        } catch (\Throwable $error) {
            SP::debug_backtrace_show($error); 
        } 
    }
}
