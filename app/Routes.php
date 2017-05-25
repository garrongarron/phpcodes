<?php
use Router\Route;
use Parser\Parser;





Route::get('/', function(){
	return  Parser::make('template/level-3');
});

Route::get('/level-0', function(){
	return  Parser::make('template/level-0');
});
Route::get('/level-1', function(){
	return  Parser::make('template/level-1');
});
Route::get('/level-2', function(){
	return  Parser::make('template/level-2');
});
Route::get('/level-3', function(){
	return  Parser::make('template/level-3');
});
