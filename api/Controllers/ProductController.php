<?php

namespace Workout\Controllers;

use Workout\Models\Category;
use Workout\Models\Product;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;



class ProductController {

//
//    //get all products
//    public function index(Request $request, Response $response, array $args) {
//
//        //get the total number of products
//        $count = Product::count();
//
//        //Get querystring variable from url
//        $params = $request->getQueryParams();
//
//        //limit and offset exist
//        $limit = array_key_exists('limit',$params) ? (int)$params['limit'] : 10; //users displayed on page
//        $offset = array_key_exists('offset', $params) ? (int)$params['offset'] : 0; // offset the first user
//
//        //pagination
//        $links = Product::getLinks($request,$limit,$offset);
//
//        //Get search terms
//        //$term = array_key_exists('q', $params) ? $params['q'] : null;
//
//
//        //sorting
//        $sort_key_array = Product::getSortKeys($request);
//        $query = Product::with('categories');
//
//        $query = $query->skip($offset)->take($limit); //limits row
//
//        //Sort output into one or more columns
//        foreach ($sort_key_array as $column => $direction) {
//            $query->orderby($column, $direction);
//        }
//
//        $products = $query->get();
//
//        $payload = [];
//        foreach ($products as $_pro){
//
//            $_categories = Category::searchCategory($_pro->product_id);
//
//            $categories = [];
//            foreach ($_categories as $_category) {
//                $categories[] = $_category->category_name;
//            }
//
//
//
//            $payload[$_pro->product_id] = [
//                'product_id' => $_pro->product_id,
//                'product_name' => $_pro->product_name,
//                'description' => $_pro->description,
//                'price' => $_pro->price,
//                'categories' => $categories
//            ];
//        }
//
//        $payload_final = [
//            'totalCount' => $count,
//            'limit' => $limit,
//            'offset' => $offset,
//            'links' => $links,
//            'sort' => $sort_key_array,
//            'data' =>$payload
//        ];
//
//        return $response->withStatus(200)->withJson($payload_final);
//
//
//
//    }

    //list all products with pagination, sort, search by query features
    public function index(Request $request, Response $response, array $args)
    {
        $results = Product::getProducts($request);
        $code = array_key_exists("status", $results) ? 500 : 200;

        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
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
        $_img_url = $request->getParam('url');


        //set new product values
        $product->product_name = $_name;
        $product->price = $_price;
        $product->description = $_description;
        $product->image_url = $_img_url;
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
        $_img_url = $request->getParam('url');

        //set new product values
        $_pro->product_name = $_name;
        $_pro->price = $_price;
        $_pro->description = $_description;
        $_pro->image_url = $_img_url;
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


