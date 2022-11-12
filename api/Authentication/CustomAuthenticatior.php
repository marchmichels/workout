<?php

namespace Workout\Authentication;


use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Workout\Models\User;


class CustomAuthenticatior
{

    public function __invoke(Request $request, Response $response, $next)
    {
        // If the custom header "WorkoutAPI-Authorization" does not exist display an error
        if (!$request->hasHeader('WorkoutAPI-Authorization')) {
            $results = array('status' => 'Authorization header not available');
            return $response->withJson($results, 404, JSON_PRETTY_PRINT);
        }

        //A user has been authenticated
        $auth = $request->getHeader('WorkoutAPI-Authorization');
        list($username, $password) = explode(':', $auth[0]);

        //return forbidden (401)
        if (!User::authenticateUser($username, $password)) {
            $results = array("status" => "Authentication failed");
            return $response->withJson($results, 401, JSON_PRETTY_PRINT);
        }
        // A user has been authenticated.
        $response = $next($request, $response);
        return $response;

    }
}