<?php 

require __DIR__ . '/../vendor/autoload.php';  

return [
    /**
     * ------------------------------------------------------------------------
     *                           S.P Framework v1.0.0
     * ------------------------------------------------------------------------
     * Assets settings. Config file for the application assets accessor settings.
     * ------------------------------------------------------------------------
     */
    'bootstrap' => [

        // Default version if not defined
        'default' => '4',

        // Assign version to route groups or named routes
        'routes' => [
            // Use Bootstrap 5 for these views/routes
            '4' => [],

            // Use Bootstrap 5 for these views/routes
            '5' => [
                '*'
            ]
        ]
    ]
];
