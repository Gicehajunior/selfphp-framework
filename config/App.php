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
    'AuthPage' => 'login'
];
