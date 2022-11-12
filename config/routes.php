<?php







$app->get('/', function ($request, $response, $args) {
    return $response->write("Hello, this is the Workout API.");
});



// User routes
$app->group('/users', function () {
    $this->get('', 'UserController:index');
    $this->get('/{id}', 'UserController:view');




});


// Product routes
$app->group('/products', function () {
    $this->get('', 'ProductController:index');
    $this->get('/{id}', 'ProductController:view');



});






$app->run();
