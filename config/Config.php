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
    'UPLOAD_MAX_FILESIZE' => '1200000000M',
    
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

    /**
     * Set whether to display errors or not.
     * Options: 'On' or 'Off'
     */
    'DISPLAY_ERRORS' => 'Off',

    /**
     * Maximum execution time of each script, in seconds.
     */
    'MAX_EXECUTION_TIME' => 180,

    /**
     * Maximum amount of time each script may spend parsing request data, in seconds.
     */
    'MAX_INPUT_TIME' => 180,

    /**
     * Maximum number of input variables allowed for each request.
     */
    'MAX_INPUT_VARS' => 10000,

    /**
     * Maximum amount of memory a script may consume.
     * Use '-1' for unlimited memory.
     */
    'MEMORY_LIMIT' => '-1',

    /**
     * Maximum size of POST data that PHP will accept.
     */
    'POST_MAX_SIZE' => '256M',

    /**
     * Maximum lifetime of session data, in seconds.
     */
    'SESSION_GC_MAXLIFETIME' => 14000,

    /**
     * Path where session data will be stored.
     */
    'SESSION_SAVE_PATH' => '/var/cpanel/php/sessions/ea-php81',

    /**
     * Maximum size of uploaded files.
     */
    'UPLOAD_MAX_FILESIZE' => '200M',

    /**
     * Whether to compress output with zlib output compression.
     * Options: 'On' or 'Off'
     */
    'ZLIB_OUTPUT_COMPRESSION' => 'Off',
];

