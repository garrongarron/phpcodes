<?php
use Router\Route;
use Viewer\Viewer;
use Header\Header;


Route::get('/', function(){
	return Viewer::show('rest-answer', array('get'));
});

Route::post('/', function(){
	return Viewer::show('rest-answer', array('post'));
});

Route::delete('/', function(){
	return Viewer::show('rest-answer', array('delete'));
});

Route::put('/', function(){
	return Viewer::show('rest-answer', array('put'));
});


$string = Route::run();
Header::run($string);



