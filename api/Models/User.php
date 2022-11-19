<?php
//Comment.php

namespace Workout\Models;

use \Illuminate\Database\Eloquent\Model;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class User extends Model
{

    const JWT_KEY = 'my token';//it can be any token that users like
    const JWT_EXPIRE = 600;//experiation period in seconds

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $timestamps = false;


    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public static function getLinks($request, $limit, $offset)
    {
        $count = self::count();
        // Get request uri and parts
        $uri = $request->getUri();
        $base_url = $uri->getBaseUrl();
        $path = $uri->getPath();
        // Construct links for pagination
        $links = array();
        $links[] = ['rel' => 'self', 'href' => $base_url . "/$path" . "?limit=$limit&offset=$offset"];
        $links[] = ['rel' => 'first', 'href' => $base_url . "/$path" . "?limit=$limit&offset=0"];
        if ($offset - $limit >= 0) {
            $links[] = ['rel' => 'prev', 'href' => $base_url . "/$path" . "?limit=$limit&offset=" . ($offset - $limit)];
        }
        if ($offset + $limit < $count) {
            $links[] = ['rel' => 'next', 'href' => $base_url . "/$path" . "?limit=$limit&offset=" . ($offset + $limit)];
        }
        $links[] = ['rel' => 'last', 'href' => $base_url . "/$path" . "?limit=$limit&offset=" . $limit * (ceil($count / $limit) - 1)];
        return $links;
    }

    public static function getSortKeys($request)
    {
        $sort_key_array = array();

        //get querystring variables from url
        $params = $request->getQueryParams();

        if (array_key_exists('sort', $params)) {
            $sort = preg_replace('/^\[|\]$|\s+/', '', $params['sort']); //remove white spaces, [, and ]
            $sort_keys = explode(',', $sort); //get all the key:direction pairs
            foreach ($sort_keys as $sort_key) {
                $direction = 'asc';                 //this is hardcoded 'asc', always sorts ascending order
                $column = $sort_key;
                if(strpos($sort_key, ':')) {
                    list($column, $direction) = explode(':', $sort_key);
                }
                $sort_key_array[$column] = $direction;
            }
        }

        return $sort_key_array;

    }

    // Update a user
    public static function updateUser($request)
    {
        // Retrieve parameters from request body
        $params = $request->getParsedBody();

        //Retrieve the user's id from url and then the user from the database
        $id = $request->getAttribute('id');
        $user = self::findOrFail($id);

        // update user
        $user->username = $params['username'];
        $user->password = password_hash($params['password'], PASSWORD_DEFAULT);
        $user->first_name = $params['first_name'];
        $user->last_name = $params['last_name'];
        $user->street_address = $params['street_address'];
        $user->city = $params['city'];
        $user->state = $params['state'];
        $user->zipcode = $params['zipcode'];


        // save user update
        $user->save();
        return $user;
    }





    // Authenticate a user by username and password. Return the user.
    public static function authenticateUser($username, $password)
    {

        $user = self::where('username', $username)->first();
        if (!$user) {
            return false;
        }
        return password_verify($password, $user->password) ? $user : false;
    }


    /*
    * Generate a JWT token.
    * The signature secret rule: the secret must be at least 12 characters
    in length;
    * contain numbers; upper and lowercase letters; and one of the
    following special characters *&!@%^#$.
    * For more details, please visit
    https://github.com/RobDWaller/ReallySimpleJWT
    */
    public static function generateJWT($id)
    {
        // Data for payload
        $user = $user = self::findOrFail($id);
        if (!$user) {
            return false;
        }
        $key = self::JWT_KEY;
        $expiration = time() + self::JWT_EXPIRE;
        $issuer = 'mychatter-api.com';
        $token = [
            'iss' => $issuer,
            'exp' => $expiration,
            'isa' => time(),
            'data' => [
                'uid' => $id,
                'name' => $user->username,
                'email' => $user->email,
            ]
        ];


        // Generate and return a token
        return JWT::encode(
            $token, // data to be encoded in the JWT
            $key, // the signing key
            'HS256' // algorithm used to sign the token; defaults to HS256
        );
    }

    // Verify a token
    public static function validateJWT($token)
    {
        $decoded = JWT::decode($token, new Key(self::JWT_KEY, 'HS256'));
        return $decoded;
    }

}