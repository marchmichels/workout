<?php
//bootstrap.php

include 'config/credentials.php';
include 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$config['displayErrorDetails'] = true;
$config['addContendLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

$capsule = new Capsule();
$capsule->addConnection([
    "driver" => "mysql",
    "host" => $db_host,
    "database" => $db_name,
    "username" => $db_user,
    "password" => $db_pass,
    "charset" => "utf8",
    "collation" => "utf8_general_ci",
    "prefix" => "" //this is optional.
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

$container = $app->getContainer();
$container['db'] = function($continer)use($capsule){
    return $capsule;
};