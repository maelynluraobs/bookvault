<?php

use Laravel\Lumen\Routing\Router; // Import the Router class from Laravel Lumen

/** @var Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// SA USER AUTH 

$router->get('/', function () use ($router) {
    echo "<center> Welcome </center>"; // Define a route for the root URL that returns a welcome message
});

$router->get('/version', function () use ($router) {
    return $router->app->version(); // Define a route to get the application version
});

Route::group([

    'prefix' => 'api' // Define a route group with the prefix 'api'

], function ($router) {
    Route::post('login', 'AuthController@login'); // Route for user login
    Route::post('logout', 'AuthController@logout'); // Route for user logout
    Route::post('refresh', 'AuthController@refresh'); // Route to refresh user token
    Route::post('user-profile', 'AuthController@me'); // Route to get user profile
});


$router->get('/', function () use ($router) {
    return $router->app->version(); // Duplicate route for the root URL to return the application version
});

// Register the /books information 
$router->get('/books', 'BookController@getBooks'); // Route to get a list of books

// Users Site 
$router->get('/user-accounts', 'UserController@index'); // Route to get a list of users
$router->post('/user-accounts', 'UserController@createUser'); // Route to create a new user
$router->get('/user-accounts/{id}', 'UserController@getUserById'); // Route to get a user by ID
$router->patch('/user-accounts/{id}', 'UserController@updateUser'); // Route to update a user by ID
$router->delete('/user-accounts/{id}', 'UserController@deleteUser'); // Route to delete a user by ID

// Book shelf from postman 
$router->get('/bookshelf', 'BookshelfController@index'); // Route to get a list of bookshelves
$router->get('/bookshelf/{id}', 'BookshelfController@show'); // Route to get a specific bookshelf by ID
$router->post('/bookshelf', 'BookshelfController@store'); // Route to create a new bookshelf
$router->patch('/bookshelf/{id}', 'BookshelfController@update'); // Route to update a bookshelf by ID
$router->delete('/bookshelf/{id}', 'BookshelfController@destroy'); // Route to delete a bookshelf by ID

