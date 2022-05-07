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

    public function save($post_object)
    {
        // extract keys passed on the post object.
        $table_column_keys = array_keys($post_object);

        $table_column_keys = implode(", ", $table_column_keys);


        // extract key values passed on the post object 

        $key_values = array_values($post_object);

        $key_values = implode("', '", $key_values);

        // DB Queries(INSERT)
        $query = "INSERT INTO $this->table($table_column_keys) VALUES('$key_values')";
        $result = mysqli_query($this->db_connection, $query); 

        if ($result == true or is_object($result) or is_object($result)) {
            return true;
        } else {
            SP::init_sql_debug($this->db_connection);
            return false;
        } 
    }

    public function fetchAll()
    {
        $query = "SELECT * FROM $this->table";
        $result = mysqli_query($this->db_connection, $query);

        SP::init_sql_debug($this->db_connection); 

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

    public function user_exists_on_condition($post_object = [])
    {
        $exists = false;

        $query = "SELECT * FROM $this->table WHERE email='" . $post_object['email'] . "'";
        $result = mysqli_query($this->db_connection, $query);

        SP::init_sql_debug($this->db_connection); 

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

    public function get_user_on_condition($post_object = [])
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
}
