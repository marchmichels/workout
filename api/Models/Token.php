<?php

/* Author: Logan Laughner
date: 11/13/2022
Object: token model
*/

namespace Workout\Models;

use \Illuminate\Database\Eloquent\Model;

class Token extends Model
{

    // Bearer token expires: seconds
    const EXPIRE = 3600;
    /* Generate a Bearer token if it does not exist for the user and store
    the token in the database.
     * Retrieve the token from the database if it already exists and has not
    expired.
    */

    public static function generateBearer($id)
    {

        $token = self::where('user', $id)->first();
        $expire = time() - self::EXPIRE;  // Token expires in 60 seconds
        if ($token) {
            // If the token has expired, create a new value and update it.
            if ($expire > date_timestamp_get($token->updated_at)) {
                //echo "token expired.";
                $token->value = bin2hex(random_bytes(64));
                $token->save();
            }
            return $token->value;
        }
        //Create a new token
        $token = new Token();
        $token->user = $id;
        $token->value = bin2hex(random_bytes(64));
        $token->save();
        return $token->value;
    }
    // Validate a Bearer token by matching the token with a database record.
    public static function validateBearer($value)
    {
        $token = self::where('value', $value)->first();
        $expire = time() - self::EXPIRE;
        return ($token && $expire < date_timestamp_get($token->updated_at))
            ? $token : false;
    }

}