<?php

namespace Workout\Controllers;

use Workout\Models\User;
use Workout\Models\Token;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


class UserController {


    //get all users
    //supports pagination and sort of users (Resource A)
    public function index(Request $request, Response $response, array $args) {

        //get total number of users
        $count = User::count();

        //get querystring from url
        $params = $request->getQueryParams();

        //limit and offset exist
        $limit = array_key_exists('limit',$params) ? (int)$params['limit'] : 10; //users displayed on page
        $offset = array_key_exists('offset', $params) ? (int)$params['offset'] : 0; // offset the first user

        //pagination
        $links = User::getLinks($request,$limit,$offset);
        //sorting
        $sort_key_array = User::getSortKeys($request);
        $query = User::with('orders');

        $query = $query->skip($offset)->take($limit); //limits row

        //Sort output into one or more columns
        foreach ($sort_key_array as $column => $direction) {
            $query->orderby($column, $direction);
        }

        $users = $query->get();

        $payload = [];
        foreach ($users as $_usr){
            $payload[$_usr->user_id] = ['first_name' => $_usr->first_name,
                'last_name' => $_usr->last_name,
                'street_address' => $_usr->street_address,
                'city' => $_usr->city,
                'state' => $_usr->state,
                'zipcode' => $_usr->zipcode,
            ];
        }

        $payload_final = [
            'totalCount' => $count,
            'limit' => $limit,
            'offset' => $offset,
            'links' => $links,
            'sort' => $sort_key_array,
            'data' =>$payload
        ];

        return $response->withStatus(200)->withJson($payload_final);




    }



    //get a single user by ID
    public function view(Request $request, Response $response, array $args) {

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

    }


    //update
    public function update(Request $request, Response $response, array $args) {
        $user = User::updateUser($request);
        $results = [
            'status' => 'user updated',
            'data' => $user
        ];
        return $response->withJson($results, 200, JSON_PRETTY_PRINT);

    }





    // Validate a user with username and password. It returns a Bearer token on success
    public function authBearer(Request $request, Response $response)
    {

        $username = $request->getParam('username');
        $password = $request->getParam('password');
        $user = User::authenticateUser($username, $password);
        if ($user) {
            $status_code = 200;

            //die(var_dump($user->user_id));

            $token = Token::generateBearer($user->user_id);
            $results = [
                'status' => 'login successful',
                'token' => $token
            ];
        } else {
            $status_code = 401;
            $results = [
                'status' => 'login failed'
            ];
        }
        return $response->withJson($results, $status_code, JSON_PRETTY_PRINT);
    }



    // Validate a user with username and password. It returns a JWT token on success.
    public function authJWT(Request $request, Response $response)
    {
        $params = $request->getParsedBody();
        $username = $params['username'];
        $password = $params['password'];
        $user = User::authenticateUser($username, $password);
        if ($user) {
            $status_code = 200;
            $jwt = User::generateJWT($user->user_id);
            $results = [
                'status' => 'login successful',
                'jwt' => $jwt,
                'name' => $user->username
            ];
        } else {
            $status_code = 401;
            $results = [
                'status' => 'login failed',
            ];
        }
        //return $results;
        return $response->withJson($results, $status_code,
            JSON_PRETTY_PRINT);
    }




}





