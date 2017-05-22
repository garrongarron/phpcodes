<?php
use Router\Route;
use Viewer\Viewer;
use Header\Header;


Route::get('/controller', 'User@init');
Route::get('/', function(){
	return Viewer::show('mapping-out', 'Using Closure');
});
Route::get('/method-not-found', 'User@xxx');
Route::get('/class-not-found', 'EmptyFile@init');
Route::get('/file-not-found', 'xxx@init');
$string = Route::run();
Header::run($string);



