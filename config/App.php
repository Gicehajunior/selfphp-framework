<?php

return [ 

    /**
     * APP DOMAIN.
     * 
     * The application runs on this URL by default.
     * You can change it in here or set it in the .env file. 
     */
    'APP_DOMAIN' => 'http://127.0.0.1:8000',


    /**
     * Dashboard config name
     * 
     * default name of the dashboard. You're required to get authentication,
     * before getting to dashboard.
     */
    'HomePage' => 'dashboard',


    /**
     * Auth login config default name
     * 
     * required to start here before getting in to dashboard area.
     * Required to use username or email and password to get authenticated to
     * the system app.
     */
    'AuthPage' => 'login'

];