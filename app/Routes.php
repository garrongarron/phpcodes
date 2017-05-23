<?php
use Router\Route;
use Viewer\Viewer;

//Landing
Route::get('/', function(){
	return Viewer::show('rest-messages', 'Go to http://localhost/user please');
});

//Rest Routing
Route::resurce('user', 'UserController', ['get', 'put','delete','post']);

//Aditional method
//It can be before or after than Route::resurce() method
Route::get('/user/show', 'UserController@show');



