<?php

/**
 * ********************************************************************************************************
 * 
 *                  SELFPHP FRAMEWORK
 * 
 * This is the main entry point for the SELFPHP Framework.
 * 
 * [ Framework Overview ]
 * SELFPHP is a lightweight PHP framework designed for simplicity,
 * flexibility, and ease of use. It follows the MVC (Model-View-Controller)
 * architectural pattern and includes various components for
 * routing, database interaction, and template rendering.
 * 
 * [ File Structure ]
 * - app/http/controllers/      : Contains controllers for handling requests.
 * - app/models/                : Houses model classes for interacting with the database.
 * - views/                     : Stores template files for rendering views.
 * - config/                    : Configuration files for database connections, Core framework files and classes, etc.
 * - public/                    : Publicly & privately accessible assets (stylesheets, images, storage, etc.). 
 * 
 * [ Getting Started ]
 * To start using SELFPHP, make sure to configure your database
 * settings in the 'config/database.php' file. Create controllers
 * in the 'controllers/' directory and corresponding views in
 * the 'views/' directory. The public assets can be placed in
 * the 'public/' directory.
 * 
 * [ Documentation ]
 * For detailed documentation and examples, visit the official
 * SELFPHP documentation at https://selfphpframework.com/docs.
 * 
 * [ Version Information ]
 * SELFPHP Framework v1.0.0
 * 
 * [ Author ]
 * Giceha Junior - https://github.com/GicehaJunior
 * 
 * [ License ]
 * This framework is released under the MIT License. See the LICENSE file for details.
 * https://github.com/Gicehajunior/selfphp-framework/blob/main/LICENSE
 * 
 * ****************************************************************************
 */


// Require autoload class for autoloading dependencies.
require __DIR__ . '/vendor/autoload.php';

/**
 * Copy Bootstrap Assets to Public Folder
 * This script handles the copying of Bootstrap assets to the public folder,
 * especially for Windows where composer json post-update-cmd script may not work.
 */
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') { 
    if (!is_dir(__DIR__ . "/public/bootstrap/css") 
        || !is_dir(__DIR__ . "/public/bootstrap/js") 
        || !is_dir(__DIR__ . "/public/assets/jquery")
    ) { 
        mkdir(__DIR__ . "/public/bootstrap/css");
        mkdir(__DIR__ . "/public/bootstrap/js");
        mkdir(__DIR__ . "/public/assets/jquery");

        if (is_dir(__DIR__ . "/vendor/twbs/bootstrap/dist/") 
            || is_dir(__DIR__ . "/vendor/twbs/bootstrap/dist/") 
            || is_dir(__DIR__ . "/vendor/components/jquery")
        ) {
            $assets = [
                glob(__DIR__ . "/vendor/twbs/bootstrap/dist/css/*.css"), 
                glob(__DIR__ . "/vendor/twbs/bootstrap/dist/js/*.js"), 
                glob(__DIR__ . "/vendor/components/jquery/*.js")
            ]; 

            foreach($assets[0] as $assetKey => $assetValue) {  
                $assetValueBasename = basename($assetValue);
                copy($assetValue, __DIR__ . "/public/bootstrap/css/" . $assetValueBasename); 
            }

            foreach($assets[1] as $assetKey => $assetValue) {
                $assetValueBasename = basename($assetValue);
                copy($assetValue, __DIR__ . "/public/bootstrap/js/" . $assetValueBasename); 
            }
            
            foreach($assets[2] as $assetKey => $assetValue) {
                $assetValueBasename = basename($assetValue);
                copy($assetValue, __DIR__ . "/public/assets/jquery/" . $assetValueBasename); 
            }
        }
        
        if (!is_dir(__DIR__ . "/public/bootstrap/css/") 
            || !is_dir(__DIR__ . "/public/bootstrap/js/") 
            || !is_dir(__DIR__ . "/public/assets/jquery/")
        ) {
            echo "<span>No Bootstrap CSS, JS, and jQuery files set up!</span>";
            exit();
        }
    } 
}

// Require Dotenv Class; To load environment variables.
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Require Routes
require __DIR__ . "/routes/web.php";
