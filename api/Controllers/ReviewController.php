<?php

namespace Workout\Controllers;

use Workout\Models\Review;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ReviewController {




    //get a single review
    public function view(Request $request, Response $response, array $args) {

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

    }



    //create a review
    public function create(Request $request, Response $response, array $args) {

        $review = new Review();
        $_rating = $request->getParam('rating');
        $_comment = $request->getParam('comment');
        $_user_id = $request->getParam('user_id');
        $_product_id = $request->getParam('product_id');

        $review->comment = $_comment;
        $review->user_id = $_user_id;
        $review->product_id = $_product_id;
        $review->rating = $_rating;
        $review->save();

        $payload = (['review_id'=> $review->review_id,
            'rating' => $review->rating,
            'comment' => $review->comment,
            'user_id' => $review->user_id,
            'product_id' => $review->product_id
        ]);

        return $response->withStatus(201)->withJson($payload);

    }

    //update a review
    public function update(Request $request, Response $response, array $args) {

        $id = $args['id'];
        $review = Review::findOrFail($id);
        $params = $request->getParsedBody();
        foreach ($params as $field => $value) {
            $review->$field = $value;
        }
        $review->save();
        if ($review->review_id) {
            $payload = ['review_id' => $review->review_id,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'user_id' => $review->user_id,
                'product_id' => $review->product_id
            ];
            return $response->withStatus(200)->withJson($payload);
        } else {
            return $response->withStatus(500);
        }

    }

    //delete a review
    public function delete(Request $request, Response $response, array $args) {

        $id = $args['id'];
        $review = Review::find($id);
        $review->delete();
        if ($review->exists) {
            return $response->withStatus(500);
        } else {
            return $response->withStatus(204)->getBody()->write("Review'/reviews/$id' has been deleted.");
        }

    }





}