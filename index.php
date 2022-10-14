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
use Workout\Models\User;
use Workout\Models\Order;
use Workout\Models\Review;
use Workout\Models\Category;



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
$app->get('/products/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];

    $product = new Product();
    $_pro = $product->find($id);

    $payload[$_pro->product_id] = ['product_name' => $_pro->product_name,
        'description' => $_pro->description
    ];

    return $response->withStatus(200)->withJson($payload);
});



//get all users
$app->get('/users', function (Request $request, Response $response, array $args) {

    $users = User::all();

    $payload = [];

    foreach ($users as $_usr) {
        $payload[$_usr->user_id] = ['first_name' => $_usr->first_name,
            'last_name' => $_usr->last_name,
            'street_address' => $_usr->street_address,
            'city' => $_usr->city,
            'state' => $_usr->state,
            'zipcode' => $_usr->zipcode,

        ];
    }
    return $response->withStatus(200)->withJson($payload);

});


//get a single user
$app->get('/users/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];

    $user = new User();
    $_usr = $user->find($id);

    $payload[$_usr->user_id] = ['first_name' => $_usr->first_name,
        'last_name' => $_usr->last_name,
        'street_address' => $_usr->street_address,
        'city' => $_usr->city,
        'state' => $_usr->state,
        'zipcode' => $_usr->zipcode,

    ];

    return $response->withStatus(200)->withJson($payload);
});


//get all reviews for a product
$app->get('/products/{id}/reviews', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $product = new Product();
    $reviews = $product->find($id)->reviews;

    $payload = [];

    foreach ($reviews as $review) {
        $payload[$review->review_id] = [
            'rating' => $review->rating,
            'comment' => $review->comment,
            'user_id' => $review->user_id,
            'product_id' => $review->product_id
        ];
    }
    return $response->withStatus(200)->withJson($payload);
});

//get a single review
$app->get('/reviews/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $review = new Review();
    $review = $review->find($id);

    $payload[$review->review_id] = [
        'rating' => $review->rating,
        'comment' => $review->comment,
        'user_id' => $review->user_id,
        'product_id' => $review->product_id
    ];
    return $response->withStatus(200)->withJson($payload);
});

//get all orders
$app->get('/orders', function (Request $request, Response $response, array $args) {
    $orders = Order::all();

    $payload = [];

    foreach ($orders as $_order) {
        $payload[$_order->order_id] = ['product_id' => $_order->product_id,
            'user_id' => $_order->user_id
        ];
    }
    return $response->withStatus(200)->withJson($payload);
});

//get a single order
$app->get('/orders/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $order = new Order();
    $order = $order->find($id);
    $product_id = $order->product_id;
    $product = new Product;
    $_pro = $product->find($product_id);
    $user_id = $order->user_id;
    $user = new User();
    $_usr = $user->find($user_id);



    $payload[$order->order_id] = [
        'product_id' => $order->product_id,
        'product_name' => $_pro->product_name,
        'user_id' => $order->user_id,
        'first_name' => $_usr->first_name,
        'last_name' => $_usr->last_name,
        'street_address' => $_usr->street_address,
        'city' => $_usr->city,
        'state' => $_usr->state,
        'zipcode' => $_usr->zipcode,
    ];
    return $response->withStatus(200)->withJson($payload);
});





$app->run();



