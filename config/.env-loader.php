<?php

require "./vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable('./');
$dotenv->load();

class EnvLoader {
    public function env_var() {
        $loaded_variables = array(
            'app_name' => $_ENV['APP_NAME'],
            'app_domain' => $_ENV['APP_DOMAIN'],
            'database_host' => $_ENV['DB_HOST'],
            'database_name' => $_ENV['DB_NAME'],
            'database_username' => $_ENV['DB_USERNAME'],
            'database_password' => $_ENV['DB_PASSWORD'] 
        );

        return $loaded_variables;
    }
}






