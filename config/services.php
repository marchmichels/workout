<?php

use Workout\Controllers\ProductController as ProductController;
use Workout\Controllers\UserController as UserController;
use Workout\Controllers\ReviewController as ReviewController;
use Workout\Controllers\OrderController as OrderController;
use Workout\Controllers\CategoryController as CategoryController;


$container['UserController'] = function ($c) {
    return new UserController();
};

$container['ProductController'] = function ($c) {
    return new ProductController();
};

$container['ReviewController'] = function ($c) {
    return new ReviewController();
};

$container['OrderController'] = function ($c) {
    return new OrderController();
};

$container['CategoryController'] = function ($c) {
    return new CategoryController();
};