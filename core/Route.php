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
			} else {
				$method = explode('@', $callback);
				$file = CONTROLLERFOLDER.'/'.$method[0].'.php';
				if(file_exists($file)){
					require_once $file;
					if(class_exists($method[0])){
						$class = $method[0];
						$o = new $class();
						if(method_exists($o, $method[1])){
							return $o->$method[1]();
						} else {
							$msg = "Method '$method[0]::$method[1]()' not found";
							return Viewer::show('mapping-out', $msg);
						}
						
					} else {
						$msg = "Class '$method[0]' not found";
						return Viewer::show('mapping-out', $msg);
					}
					
				} else {
					$msg = "File '$file' not found";
					return Viewer::show('mapping-out', $msg);
				}
			}
		} else {
			Header::set("HTTP/1.0 404 Not Found");
			return Viewer::show('404');
		} 
	}
}