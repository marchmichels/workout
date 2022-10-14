<?php
/*
 * Marc Michels
 * File: index.php
 */

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap.php';

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Workout\Models\Product;


$app->get('/', function ($request, $response, $args) {
    return $response->write("Hello, this is the Workout API.");
});


//get all products
$app->get('/products', function (Request $request, Response $response, array $args) {

    $products = Product::all();

    $payload = [];

    foreach ($products as $_pro) {
        $payload[$_pro->product_id] = ['product_name' => $_pro->product_name,
            'description' => $_pro->description
        ];
    }
    return $response->withStatus(200)->withJson($payload);

});




//get a single product



//get all users



//get a single user



//get all reviews for a product

//get a single review


//get all orders

//get a single order










$app->run();



