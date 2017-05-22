<?php
namespace Router;

use Viewer\Viewer;
use Header\Header;

class Route
{
	static private $routes = [];
	static public function get($url,$callback){
		self::$routes['GET'][$url] = $callback;
	}
	
	static public function post($url,$callback){
		self::$routes['POST'][$url] = $callback;
	}
	
	static public function put($url,$callback){
		self::$routes['PUT'][$url] = $callback;
	}
	
	static public function delete($url,$callback){
		self::$routes['DELETE'][$url] = $callback;
	}
	
	static public function patch($url,$callback){
		self::$routes['PATCH'][$url] = $callback;
	}
	
	static public function run(){
		$key = Router::getRoute();
		array_shift($key);
		$key = '/'.implode('/', $key);
		if(isset(self::$routes[$_SERVER['REQUEST_METHOD']][$key])){
			$callback = self::$routes[$_SERVER['REQUEST_METHOD']][$key];
			if(is_callable($callback)){
				return $callback();
			}
		} else {
			Header::set("HTTP/1.0 404 Not Found");
			return Viewer::show('404');
		} 
	}
}