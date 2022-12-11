<?php

namespace Workout\Controllers;

use Workout\Models\Category;
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

                $_categories = Category::searchCategory($_pro->product_id);

                $categories = [];
                foreach ($_categories as $_category) {
                    $categories[] = $_category->category_name;
                }

                $payload_final[$_pro->product_id] = [
                    'product_id' => $_pro->product_id,
                    'product_name' => $_pro->product_name,
                    'description' => $_pro->description,
                    'price' => $_pro->price,
                    'categories' => $categories
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

    //create a product
    public function create(Request $request, Response $response, array $args)
    {
        //create a new product
        $product = new Product();
        $_name = $request->getParam('product_name');
        $_price = $request->getParam('price');
        $_description = $request->getParam('description');

        //set new product values
        $product->product_name = $_name;
        $product->price = $_price;
        $product->description = $_description;
        $product->save();

        //create a new category
        $category = new Category();
        $_product_id = $product->product_id;
        $_category = $request->getParam('category');

        //set new category values
        $category->product_id = $_product_id;
        $category->category_name = $_category;
        $category->save();






        $payload = (['status'=> "product $_product_id created."
        ]);

        return $response->withStatus(201)->withJson($payload);

    }

    //update a product
    public function update(Request $request, Response $response, array $args) {

        $product = new Product();
        //the product to update
        $_pro = $product->findOrFail($args['id']);


        $_name = $request->getParam('product_name');
        $_price = $request->getParam('price');
        $_description = $request->getParam('description');

        //set new product values
        $_pro->product_name = $_name;
        $_pro->price = $_price;
        $_pro->description = $_description;
        $_pro->save();

        //find a category
        $_cat = new Category();
        $_category = $_cat::searchCategory($args['id']);
        $_new_category = $request->getParam('category');
        $_category[0]->category_name = $_new_category;
        $_category[0]->save();






        $payload = (['status'=> "product $_pro->product_id updated."
        ]);

        return $response->withStatus(201)->withJson($payload);


    }

    //delete a product
    public function delete(Request $request, Response $response, array $args) {

        $id = $args['id'];
        $product = Product::find($id);

        $_cat = new Category();
        $_category = $_cat::searchCategory($args['id']);
        $cat_id = $_category[0]->category_id;
        $category = Category::find($cat_id);

        $product->delete();
        $category->delete();
        if($product->exists || $category->exists) {
            return $response->withStatus(500);
        } else {
            return $response->withStatus(204)->getBody()->write("Product'/products/$id' has been deleted.");
        }



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


