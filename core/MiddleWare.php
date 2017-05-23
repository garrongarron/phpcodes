<?php
namespace MiddleWare;

use Router\Route;
class MiddleWare
{
	static private $middleWareRouteBefore = [];
	static private $middleWareRouteAfter = [];
	static private $middleWare = [];
	static private $group = [];
	static private $callbackName = NULL;
	static private $when = NULL;
	static private $where = array();
	
	static public function setMiddleWareRoute($method, $name){
		if(self::$when=='before'){
			self::$middleWareRouteBefore[$method][$name] = self::$callbackName;
		} elseif (self::$when=='after'){
			self::$middleWareRouteAfter[$method][$name] = self::$callbackName;
		}
		
	}
	
	static public function getMiddleWareRoute($name){
		return self::$middleWareRoute[$name];
	}
	
	static public function setMiddleWare($name, $callback){
			self::$middleWare[$name] = $callback;
	}
	
	static public function getMiddleWare($name){
		return self::$middleWare[$name];
	}
	
	static public function group($name, $callback){
		if(isset($name['before'])){
			self::$when = 'before';
		} elseif (isset($name['after'])){
			self::$when = 'after';
		}
		self::$callbackName = $name[self::$when];
		$callback();
		self::$callbackName = null;
	}
	
	static public function before($method, $name){
		self::$where = array($method, $name);
		if(isset(self::$middleWareRouteBefore[$method][$name])){
			$callback= self::$middleWare[self::$middleWareRouteBefore[$method][$name]];
			$callback();
		}
	}
	
	static public function after(){
		if(isset(self::$middleWareRouteAfter[self::$where[0]][self::$where[1]])){
			$callback= self::$middleWare[self::$middleWareRouteAfter[self::$where[0]][self::$where[1]]];
			$callback();
		}
	}
}