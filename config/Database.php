<?php

return [ 
    
    /*
    |--------------------------------------------------------------------------
    | Database Configurations
    |--------------------------------------------------------------------------
    | This section contains configurations for various database connections used
    | in the application. Each database connection includes settings such as
    | host, port, database name, username, and password, as well as specific
    | options and drivers for different database management systems.
    |
    | Make sure to adjust these configurations based on your actual database
    | credentials and requirements. Additionally, consider consulting the
    | documentation of your chosen PHP database library for further details on
    | available configuration options.
    |
    | Supported Database Drivers:
    | - MySQL
    | - PostgreSQL
    | - MongoDB
    | - SQLite
    | - SQL Server
    |
    | Example Configurations:
    | - 'mysql' configuration for MySQL database
    | - 'postgresql' configuration for PostgreSQL database
    | - 'mongodb' configuration for MongoDB database
    | - 'sqlite' configuration for SQLite database
    | - 'sqlsrv' configuration for SQL Server database
    |
    | Feel free to add more configurations for additional databases as needed.
    |--------------------------------------------------------------------------
    */
    'default' => 'mysql',

    'mysql' => [
        'host' => 'localhost',
        'port' => 3306,
        'username' => 'database_user',
        'password' => 'database_password',
        'database' => 'database_name',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'strict' => true,
        'engine' => null,
        'options' => [ 
            'MYSQLI_OPT_CONNECT_TIMEOUT' => '',
            'MYSQLI_OPT_READ_TIMEOUT' => '',
            'MYSQLI_OPT_LOCAL_INFILE' => '',
            'MYSQLI_INIT_COMMAND' => '',
            'MYSQLI_SET_CHARSET_NAME' => '',
            'MYSQLI_READ_DEFAULT_FILE' => '',
            'MYSQLI_READ_DEFAULT_GROUP' => '',
            'MYSQLI_SERVER_PUBLIC_KEY' => '',
            'MYSQLI_OPT_NET_CMD_BUFFER_SIZE' => '',
            'MYSQLI_OPT_NET_READ_BUFFER_SIZE' => '',
            'MYSQLI_OPT_INT_AND_FLOAT_NATIVE' => '',
            'MYSQLI_OPT_SSL_VERIFY_SERVER_CERT' => '',

        ],
    ],

    'postgresql' => [
        'host' => 'localhost',
        'port' => 5432,
        'username' => 'pgsql_user',
        'password' => 'pgsql_password',
        'database' => 'pgsql_database',
        'schema' => 'public',
        'sslmode' => 'prefer',
        'options' => [
            // Additional PostgreSQL options if needed
        ],
    ],

    'mongodb' => [
        'host' => 'localhost',
        'port' => 27017,
        'username' => 'mongodb_user',
        'password' => 'mongodb_password',
        'database' => 'mongodb_database',
        'options' => [
            'authMechanism' => 'SCRAM-SHA-256',
            'authSource' => 'admin',
            // Additional MongoDB options if needed
        ],
    ],

    'sqlite' => [
        'driver' => 'sqlite',
        'database' => __DIR__ . '/database.sqlite',
        'prefix' => '',
        'foreign_key_constraints' => true,
        // Additional SQLite options if needed
    ],

    'sqlsrv' => [
        'host' => 'localhost',
        'port' => 1433,
        'database' => 'sqlsrv_database',
        'username' => 'sqlsrv_user',
        'password' => 'sqlsrv_password',
        'charset' => 'utf8',
        'prefix' => '',
        'options' => [
            // Additional SQL Server options if needed
        ],
    ], 

    /*
    |--------------------------------------------------------------------------
    | Additional Framework Configurations
    |--------------------------------------------------------------------------
    */
    'cache' => [
        'driver' => __DIR__ . '/db',
        'path' => __DIR__ . '/cache',
    ],

    'logs' => [
        'enabled' => true,
        'path' => __DIR__ . '/logs',
    ],
];
