<?php

namespace Workout\Controllers;

use Workout\Models\Order;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class OrderController {


    //get all orders
    public function index(Request $request, Response $response, array $args) {
        $orders = Order::all();

        $payload = [];

        foreach ($orders as $_order) {
            $product_id = $_order->product_id;
            $product = new Product();
            $_pro = $product->find($product_id);
            $user_id = $_order->user_id;
            $user = new User();
            $_usr = $user->find($user_id);

            $payload[$_order->order_id] = [
                'product_id' => $_order->product_id,
                'product_name' => $_pro->product_name,
                'user_id' => $_order->user_id,
                'first_name' => $_usr->first_name,
                'last_name' => $_usr->last_name,
                'street_address' => $_usr->street_address,
                'city' => $_usr->city,
                'state' => $_usr->state,
                'zipcode' => $_usr->zipcode,
            ];

        }

        return $response->withStatus(200)->withJson($payload);

    }


        //get a single order
    public function view(Request $request, Response $response, array $args) {
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

    }

}