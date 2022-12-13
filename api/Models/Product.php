<?php
//Comment.php

namespace Workout\Models;

use \Illuminate\Database\Eloquent\Model;
use Workout\Models\Category;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'product_id';


    //get all products, with pagination, sort and search by query features.
    public static function getProducts($request)
    {

        //get the total number of products
        $count = self::count();

        //get query string variables from url
        $params = $request->getQueryParams();

        //Do limit and offset exist?
        $limit = array_key_exists('limit', $params) ? (int)$params['limit'] : 10; // items per page
        $offset = array_key_exists('offset', $params) ? (int)$params['offset'] : 0; // offset of the first item

        //Get search terms
        $term = array_key_exists('q', $params) ? $params['q'] : null;

        if (!is_null($term)) {
            $products = self::searchProducts($term);
            return $products;
        } else {
            //Pagination
            $links = self::getLinks($request, $limit, $offset);

            // Sorting.
            $sort_key_array = self::getSortKeys($request);

            $query = Product::with('categories');
            //$query = Message::all();
            $query = $query->skip($offset)->take($limit);  // limit the rows

            // sort the output by one or more columns
            foreach ($sort_key_array as $column => $direction) {
                $query->orderBy($column, $direction);
            }

            $products = $query->get();

            //construct data for the response
            $results = [
                'totalCount' => $count,
                'limit' => $limit,
                'offset' => $offset,
                'links' => $links,
                'sort' => $sort_key_array,
                'data' => $products
            ];
            return $results;
        }
    }

    public static function searchProducts($terms)
    {

        if (is_numeric($terms)) {
            $query = self::with('categories')->where('product_id', "like", "%$terms%");
        } else {
            $query = self::with('categories')->where('product_name', 'like', "%$terms%")
                ->orWhere('description', 'like', "%$terms%");
        }
        $data = $query->get();














        //construct data for the response
        $results = [
            'data' => $data
        ];
        return $results;














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

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'product_id');
    }

    public function order()
    {
        return $this->hasMany(Order::class, 'product_id');
    }


}