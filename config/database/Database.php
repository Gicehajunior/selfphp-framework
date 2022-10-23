<?php

namespace SelfPhp\database;

use SelfPhp\SP;
use SelfPhp\database\DatabaseConfig;

class Database {
    
    public $host;

    public $db_name;

    public $db_username;

    public $db_password;

    public $db_connection;

    public function __construct()
    {
        $this->host = env('DB_HOST');
        $this->db_name = env('DB_NAME');
        $this->db_username = env('DB_USERNAME');
        $this->db_password = env('DB_PASSWORD');
    }

    public function connect() {
        try {
            $database_connection = new DatabaseConfig($this->host, $this->db_name, $this->db_username, $this->db_password);

            $this->db_connection = $database_connection->getConnection();

            return $this->db_connection;
        } catch (\Throwable $error) {
            SP::debug_backtrace_show($error);
        }
    }
}

