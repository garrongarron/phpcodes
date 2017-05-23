<?php
use Router\Route;
use Viewer\Viewer;
use MiddleWare\MiddleWare;


MiddleWare::setMiddleWare('isLogged', function(){
	
	function isLogged(){
		return true;//<-----------------change this by false
	}
	
	if(!isLogged()){
		header('Location: http://localhost/user-not-logged');
	}
});

//Landing
Route::get('/', function(){
	return Viewer::show('rest-messages', 'Click on  http://localhost/user please');
});
//User not authenticated
Route::get('/user-not-logged', function(){
	return Viewer::show('user-not-logged');
});

MiddleWare::group(array('before'=>'isLogged'), function(){

	//Rest Routing
	Route::resurce('user', 'UserController', ['get', 'put','delete','post']);

	//Aditional method
	//It can be before or after than Route::resurce() method
	Route::get('/user/show', 'UserController@show');
});
// MiddleWare::group(array('after'=>'sayHello'), function(){
// 	//Rest Routing
// 	Route::resurce('user', 'UserController', ['get', 'put','delete','post']);
// });



