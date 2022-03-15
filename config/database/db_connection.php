
<?php

require "databaseConfig.php";

class Database {
    
    public $host;

    public $db_name;

    public $db_username;

    public $db_password;

    public $db_connection;

    public function __construct()
    {
        $this->host = $_ENV['DB_HOST'];
        $this->db_name = $_ENV['DB_NAME'];
        $this->db_username = $_ENV['DB_USERNAME'];
        $this->db_password = $_ENV['DB_PASSWORD'];
    }

    public function connect() {
        $database_connection = new DatabaseConfig($this->host, $this->db_name, $this->db_username, $this->db_password);

        $this->db_connection = $database_connection->getConnection();

        return $this->db_connection;
    }
}

