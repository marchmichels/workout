<?php

namespace Workout\Controllers;

use Workout\Models\Product;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;



class ProductController {


    //get all products
    public function index(Request $request, Response $response, array $args) {


        //Get querystring variable from url
        $params = $request->getQueryParams();

        //Get search terms
        $term = array_key_exists('q', $params) ? $params['q'] : null;


        if (!is_null($term)) {
            $products = Product::searchProducts($term);
            $payload_final = [];
            foreach ($products as $_pro) {
                $payload_final[$_pro->product_id] = ['product_name' => $_pro->product_name,
                    'description' => $_pro->description
                ];
            }
        } else {
            $products = Product::all();

            $payload_final = [];

            foreach ($products as $_pro) {
                $payload_final[$_pro->product_id] = ['product_name' => $_pro->product_name,
                    'description' => $_pro->description
                ];
            }
        }

        return $response->withStatus(200)->withJson($payload_final);

    }




    //get one product by ID
    public function view(Request $request, Response $response, array $args) {

        $id = $args['id'];

        $product = new Product();
        $_pro = $product->find($id);

        $payload[$_pro->product_id] = ['product_name' => $_pro->product_name,
            'description' => $_pro->description
        ];

        return $response->withStatus(200)->withJson($payload);

    }


    //get all reviews for a product
    //view reviews
    public function viewReviews(Request $request, Response $response, array $args) {
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
    }






}


