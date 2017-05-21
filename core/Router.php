<?php
namespace Router;

class Router
{
	static private $parameters;
	static private $route;
	static private $self;
	
	public function __construct(){
		$url = explode('?', $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		if(count($url)>1){
			self::$parameters = array_pop($url);
			self::$parameters = explode('&', self::$parameters);
			$params = [];
			foreach (self::$parameters as $v){
				$data = explode('=', $v);
				$params[$data[0]] = (isset($data[1]))?$data[1]:'';
			}
			self::$parameters = $params;
		}
		self::$route = explode('/', $url[0]);
	}
	
	static private function getInstance(){
		if(empty(self::$self)){
			self::$self = new Router();
		}
		return self::$self;
	}
	
	static public function getParameters(){
		self::getInstance();
		return self::$parameters;
	}
	
	static public function getRoute(){
		self::getInstance();
		return self::$route;
	}

}