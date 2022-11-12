<?php
/*
 * Marc Michels
 * File: index.php
 */

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config/bootstrap.php';




////get all reviews for a product
//$app->get('/products/{id}/reviews', function (Request $request, Response $response, array $args) {
//    $id = $args['id'];
//    $product = new Product();
//    $reviews = $product->find($id)->reviews;
//
//    $payload = [];
//
//    foreach ($reviews as $review) {
//        $payload[$review->review_id] = [
//            'rating' => $review->rating,
//            'comment' => $review->comment,
//            'user_id' => $review->user_id,
//            'product_id' => $review->product_id
//        ];
//    }
//    return $response->withStatus(200)->withJson($payload);
//});
//
////get a single review
//$app->get('/reviews/{id}', function (Request $request, Response $response, array $args) {
//    $id = $args['id'];
//    $review = new Review();
//    $review = $review->find($id);
//
//    $payload[$review->review_id] = [
//        'rating' => $review->rating,
//        'comment' => $review->comment,
//        'user_id' => $review->user_id,
//        'product_id' => $review->product_id
//    ];
//    return $response->withStatus(200)->withJson($payload);
//});
//
////create a review (resource C)
//$app->post('/reviews', function ($request, $response, $args) {
//
//    $review = new Review();
//    $_rating = $request->getParam('rating');
//    $_comment = $request->getParam('comment');
//    $_user_id = $request->getParam('user_id');
//    $_product_id = $request->getParam('product_id');
//
//    $review->comment = $_comment;
//    $review->user_id = $_user_id;
//    $review->product_id = $_product_id;
//    $review->rating = $_rating;
//    $review->save();
//
//    $payload = (['review_id'=> $review->review_id,
//        'rating' => $review->rating,
//        'comment' => $review->comment,
//        'user_id' => $review->user_id,
//        'product_id' => $review->product_id
//        ]);
//
//    return $response->withStatus(201)->withJson($payload);
//
//
//
//
//});
//
////update a review (resource C)
//$app->patch('/reviews/{id}', function ($request, $response, $args) {
//
//    $id = $args['id'];
//    $review = Review::findOrFail($id);
//    $params = $request->getParsedBody();
//    foreach ($params as $field => $value) {
//        $review->$field = $value;
//    }
//    $review->save();
//    if ($review->review_id) {
//        $payload = ['review_id' => $review->review_id,
//            'rating' => $review->rating,
//            'comment' => $review->comment,
//            'user_id' => $review->user_id,
//            'product_id' => $review->product_id
//        ];
//        return $response->withStatus(200)->withJson($payload);
//    } else {
//        return $response->withStatus(500);
//    }
//
//});
//
////delete a review (resource C)
//$app->delete('/reviews/{id}', function ($request, $response, $args) {
//    $id = $args['id'];
//    $review = Review::find($id);
//    $review->delete();
//    if ($review->exists) {
//        return $response->withStatus(500);
//    } else {
//        return $response->withStatus(204)->getBody()->write("Review'/reviews/$id' has been deleted.");
//    }
//
//});
//
////get all orders
//$app->get('/orders', function (Request $request, Response $response, array $args) {
//
//
//    $orders = Order::all();
//
//    $payload = [];
//
//    foreach ($orders as $_order) {
//        $product_id = $_order->product_id;
//        $product = new Product();
//        $_pro = $product->find($product_id);
//        $user_id = $_order->user_id;
//        $user = new User();
//        $_usr = $user->find($user_id);
//
//        $payload[$_order->order_id] = [
//            'product_id' => $_order->product_id,
//            'product_name' => $_pro->product_name,
//            'user_id' => $_order->user_id,
//            'first_name' => $_usr->first_name,
//            'last_name' => $_usr->last_name,
//            'street_address' => $_usr->street_address,
//            'city' => $_usr->city,
//            'state' => $_usr->state,
//            'zipcode' => $_usr->zipcode,
//        ];
//
//    }
//
//    return $response->withStatus(200)->withJson($payload);
//
//});
//
////get a single order
//$app->get('/orders/{id}', function (Request $request, Response $response, array $args) {
//    $id = $args['id'];
//    $order = new Order();
//    $order = $order->find($id);
//    $product_id = $order->product_id;
//    $product = new Product;
//    $_pro = $product->find($product_id);
//    $user_id = $order->user_id;
//    $user = new User();
//    $_usr = $user->find($user_id);
//
//    $payload[$order->order_id] = [
//        'product_id' => $order->product_id,
//        'product_name' => $_pro->product_name,
//        'user_id' => $order->user_id,
//        'first_name' => $_usr->first_name,
//        'last_name' => $_usr->last_name,
//        'street_address' => $_usr->street_address,
//        'city' => $_usr->city,
//        'state' => $_usr->state,
//        'zipcode' => $_usr->zipcode,
//    ];
//    return $response->withStatus(200)->withJson($payload);
//});
//
////get all categories
//$app->get('/categories', function (Request $request, Response $response, array $args) {
//    $categories = Category::all()->unique('category_name');
//    $payload = [];
//    foreach ($categories as $category) {
//        $payload[$category->category_id] = ['category_name' => $category->category_name,
//            'product_id' => $category->product_id
//        ];
//    }
//    return $response->withStatus(200)->withJson($payload);
//
//});
//
////get one category by ID
//$app->get('/categories/{id}', function (Request $request, Response $response, array $args) {
//    $id = $args['id'];
//    $category = new Category();
//    $category = $category->find($id);
//
//    $payload[$category->category_id] = [
//        'category_name' => $category->category_name,
//        'product_id' => $category->product_id
//    ];
//    return $response->withStatus(200)->withJson($payload);
//});
//
//$app->run();

