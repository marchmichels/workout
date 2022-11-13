<?php
//bootstrap.php



// Load system configuration settings
$config = require __DIR__ . '/config.php';

// Load the Composer autoloader.
//require $config['app_root'] . '/vendor/autoload.php';
require __DIR__ . '/../vendor/autoload.php';

// Prepare app
$app = new \Slim\App(['settings' => $config]);

// Add dependencies to the Container
require __DIR__ . '/dependencies.php';

// Load the service factory
require __DIR__ . '/services.php';

// customer routes
require __DIR__ . '/routes.php';
