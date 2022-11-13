<?php

use Illuminate\Database\Capsule\Manager as Capsule;

// Get the Container instance
$container = $app->getContainer();

// Overwrite the default notFoundHandler to return a json
$container['notFoundHandler'] = function () {
    return function ($request, $response) {
        return $response->withJson(["status" => "Request not found"], 500);
    };
};

// Overwrite the default PHP exception handler
$container['errorHandler'] = function () {
    return function ($request, $response, $exception) {
        return $response->withJson(["status" => $exception->getMessage()], 500);
    };
};

// Overwrite the default PHP 7 error handler
$container['phpErrorHandler'] = function ($container) {
    return $container['errorHandler'];
};

// Configure Eloquent
$capsule = new Capsule();
$capsule->addConnection($container['settings']['db']);

$capsule->setAsGlobal();
$capsule->bootEloquent();

// Add Eloquent capsule to the DIC.
// This function gets called only when the capsule is actually used, e.g. $this->db
$container['db'] = function($capsule) {
    return $capsule;
};
