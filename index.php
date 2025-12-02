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

// Require SP DB Helper class.
use SelfPhp\DB\Serve;

// Require Dotenv Class; To load environment variables.
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Add DB.
$serve = new Serve();
$serve->addDBManager();

// Require Routes
require __DIR__ . "/routes/web.php";
