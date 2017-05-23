<?php
use Router\Route;
use dbms\mysql\DB;
use Model\User;

Route::get('/', function(){
	//DB::qta() "Query To Array";
	echo json_encode(DB::qta("select 'Mysql' as Hello"));
	
	//Create table if not exist
	//setUp table inserting fake users
	$user = User::getInstance();
		
	//Examples
	echo '<h3>Get #1: </h3>';
	$data = $user->setId(1)->select();
	var_dump($data);
	
	echo '<h3>Update #1: </h3>';
	$user->setName('John'.date('s'))->update();
	$data = $user->select();// keeps being the same => $user->setId(1)
	var_dump($data);
	
	echo '<h3>Get All: </h3>';
	$user->clearData();// Clear Object Data 
	$data = $user->select();// Empty Object 
	var_dump($data);
	
	echo '<h3>Delete #1: </h3>';
	$user->setId(1)->delete();
	echo 'Done!';

	
	echo '<h3>Get All: </h3>';
	$user->clearData();
	$data = $user->select();
	var_dump($data);
	
	echo '<a href="http://localhost/drop">Drop Table User</a>';
});

Route::get('/drop', function(){
	DB::q("DROP TABLE `MODULES`.`users`");
	echo '"DROP TABLE `MODULES`.`users`" Executed!<br>';
	echo 'Table droped<br>';
	echo '<a href="http://localhost">Go home</a>';
});