<?php

namespace Workout\Controllers;

use Workout\Models\Category;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class CategoryController {

    //get all categories
    public function index(Request $request, Response $response, array $args) {
        $categories = Category::all()->unique('category_name');
        $payload = [];
        foreach ($categories as $category) {
            $payload[$category->category_id] = ['category_name' => $category->category_name,
                'product_id' => $category->product_id
            ];
        }
        return $response->withStatus(200)->withJson($payload);

    }

    //get one category by ID
    public function view(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $category = new Category();
        $category = $category->find($id);

        $payload[$category->category_id] = [
            'category_name' => $category->category_name,
            'product_id' => $category->product_id
        ];
        return $response->withStatus(200)->withJson($payload);

    }

}