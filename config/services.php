<?php

use Workout\Controllers\ProductController as ProductController;
use Workout\Controllers\UserController as UserController;

$container['UserController'] = function ($c) {
    return new UserController();
};

$container['ProductController'] = function ($c) {
    return new ProductController();
};