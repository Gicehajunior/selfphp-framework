<?php

return [
    /**
     * ------------------------------------------------------------------------
     *                           S.P Framework v1.0.0
     * ------------------------------------------------------------------------
     * Application settings. Config file for the application.
     * 
     * This file contains essential configurations for the S.P Framework v1.0.
     * Please review and modify settings as needed for your application.
     * 
     * Note: Make sure to set the correct configs for your application.
     * ------------------------------------------------------------------------
     */

    /**
     * Set default timezone to Africa/Nairobi
     * 
     * Note: The timezone must be supported by the application.
     */
    'TIMEZONE' => 'Africa/Nairobi',

    /**
     * Set the maximum file upload size to 12 megabytes
     * 
     * Note: The value must be in bytes.
     */
    'UPLOAD_MAX_FILESIZE' => '12M',
    
    /**
     * Set the default language for the application
     * 
     * Note: The language must be supported by the application.
     */
    'LANGUAGE' => 'en',

    /**
     * Set the default character set for the application
     * 
     * Note: The character set must be supported by the application.
     */
    'CHARACTER_ENCODING' => 'utf-8',

    /**
     * Set the default currency for the application
     * 
     * Note: The currency must be supported by the application.
     *     The currency must be a valid ISO 4217 currency code.
     */
    'CURRENCY' => 'KES',

    /**
     * Set the default locale for the application
     * 
     * Note: The locale must be supported by the application.
     */
    'LOCALE' => 'en_US',
    
    /**
     * Set the default locale for the application
     * 
     * Note: This is the default debug mode for the application.
     *      Set to false when deploying the application.
     */
    'DEBUG' => true,

    /** Session configuration
     * 
     * Note: Session lifetime is in minutes.
     */
    'SESSION_LIFETIME' => 120,

    /**
     * Cache configuration for the application
     * 
     * Note: Cache lifetime is in seconds.
     *     Set to 0 to disable caching.
     */
    'CACHE_ENABLED' => true,
    'CACHE_LIFETIME' => 3600, // in seconds
    
    /**
     * API key for external services, third party APIs, etc.
     * To generate an API key, use `selfphp generate:api key -l [length]`,
     * where [length] is the length of the API key to generate.
     * 
     * selfphp cli tool is not yet available. To generate an API key, visit
     * https://www.selfphp.com/api-key-generator
     * 
     * Note: This is the default API key for the application.
     *     Set to false if not using an API key.
     */
    'API_KEY' => false, // e.g. '1234567890abcdef1234567890abcdef'
];

