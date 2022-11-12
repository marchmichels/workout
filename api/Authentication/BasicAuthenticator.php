<?php

namespace Workout\Authentication;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Workout\Models\User;


class BasicAuthenticator
{

    public function __invoke(Request $request, Response $response, $next)
    {
        var_dump(getallheaders());
        // If the header named "Authorization" does not exist, display an error
        if (!$request->hasHeader('Authorization')) {

            $results = array('status' => 'Authorization header not available.');
            return $response->withJson($results, 404, JSON_PRETTY_PRINT);
        }

        // Authorization header exists, retrieve the header and the header value
        $auth = $request->getHeader('Authorization');


        $apikey = substr($auth[0], strpos($auth[0], ' ') + 1);

        list($user, $password) = explode(':', base64_decode($apikey));

        if (!User::authenticateUser($user, $password)) {
            $results = array('status' => 'Authentication failed');
            return $response->withHeader('WWW-Authenticate', 'Basic realm="Workout API"')->withJson($results, 401, JSON_PRETTY_PRINT);
        }

        //proceed since the user has been authenticated
        $response = $next($request, $response);
        return $response;
    }

}