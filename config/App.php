<?php

return [ 
    /**
     * APP NAME
     * 
     * This is the name of the application if no APP_NAME is set in the .env file.
     * You're permitted to change this name to a name of your preference.
     */
    'APP_NAME' => 'SelfPHP',

    /**
     * APP DOMAIN.
     * 
     * The application runs on this URL by default.
     * You can change it here or set it in the .env file. 
     */
    'APP_DOMAIN' => 'http://127.0.0.1:8000',

    /**
     * Root DIR Path
     * 
     * This is the root directory of the application. 
     */
    'ROOT_DIRECTORY' => $_SERVER['DOCUMENT_ROOT'],

    /**
     * Resource Views Directory
     * 
     * This is the directory where the views are stored. This is the default directory.
     * The folder is primarily used to store the views of the application.
     */
    'RESOURCE_VIEWS_DIRECTORY' => 'resources',

    /**
     * Controller Path
     * 
     * This is the directory where the controllers are stored. 
     * You can add more directories to the array. 
     */
    'CONTROLLER_PATH' => [
        "app/http/controllers",
        "app/http/auth"
    ],

    /**
     * Model Path
     * 
     * This is the directory where the models are stored. 
     */
    'MODEL_PATH' => "app/models",

    /**
     * Middleware Path
     * 
     * This is the directory where the middleware are stored. 
     */
    'MIDDLEWARE_PATH' => "app/http/middleware",

    /**
     * Route Path
     * 
     * This is the directory where the routes are stored.
     * You can change it here or set it in the .env file.
     */
    'ROUTE_PATH' => "routes",

    /**
     * Public Path
     * 
     * This is the directory where the public files are stored.
     */
    'PUBLIC_PATH' => "public",

    /**
     * Storage Path
     * 
     * This is the directory where the storage are stored.
     * You can change it here or set it in the .env file.
     */
    'STORAGE_PATH' => "public/storage",

    /**
     * ASSETS Path
     * 
     * This is the directory where the assets are stored.
     * You can change it here or set it in the .env file.
     */
    'ASSETS_PATH' => "public",

    /**
     * Dashboard config name
     * 
     * Default name of the dashboard. Authentication is required to access the dashboard.
     */
    'HomePage' => 'dashboard',

    /**
     * Auth login config default name
     * 
     * Start here before accessing the dashboard area.
     * Use username or email and password for authentication.
     */
    'AuthPage' => 'login',
];
