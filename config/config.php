<?php




return [



    'displayErrorDetails' => true,

    'addContentLengthHeader' => false,

    // Determine the application root folder location
    'app_root' => $_SERVER['DOCUMENT_ROOT'],

    /*
     * This array contains database connection settings.
     */
    'db' => [
        'driver' => "mysql",
        'host' => '127.0.0.1',
        'port' => 3306,
        'database' => 'workout',
        'username' => 'phpuser',
        'password' => 'phpuser',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '' //this is optional
    ]

];