<?php


use Workout\Middleware\Logging as WorkoutLogging;
use Workout\Authentication\CustomAuthenticatior;
use Workout\Authentication\BasicAuthenticator;
use Workout\Authentication\BearerAuthenticator;
use Workout\Authentication\JWTAuthenticator;





$app->get('/', function ($request, $response, $args) {
    return $response->write("Hello, this is the Workout API.");
});



// User routes
$app->group('/users', function () {
    $this->get('', 'UserController:index');
    $this->get('/{id}', 'UserController:view');

    $this->post('', 'UserController:create');

    $this->patch('/{id}', 'UserController:update');

    $this->post('/authBearer', 'UserController:authBearer');
    $this->post('/authJWT', 'UserController:authJWT');


});


//post authentication routes
$app->group('', function() {


// Product routes
    $this->group('/products', function () {
        $this->get('', 'ProductController:index');
        $this->get('/{id}', 'ProductController:view');
        $this->get('/{id}/reviews', 'ProductController:viewReviews');


    });

// Review routes
    $this->group('/reviews', function () {

        $this->get('/{id}', 'ReviewController:view');

        $this->post('/{id}', 'ReviewController:create');
        $this->patch('/{id}', 'ReviewController:update');
        $this->delete('/{id}', 'ReviewController:delete');


    });

// Order routes
    $this->group('/orders', function () {
        $this->get('', 'OrderController:index');
        $this->get('/{id}', 'OrderController:view');


    });

// Category routes
    $this->group('/categories', function () {
        $this->get('', 'CategoryController:index');
        $this->get('/{id}', 'CategoryController:view');


    });
})
//->add(new CustomAuthenticatior());
//->add(new BasicAuthenticator());
//->add(new BearerAuthenticator());
->add(new JWTAuthenticator());


$app->add(new WorkoutLogging());
$app->run();
