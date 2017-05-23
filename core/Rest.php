<?php
namespace Rest;

class Rest
{
	static private $parameters = [];
	static private $restModels = [];
	static public function setParameters($key, $value){
		self::$parameters[$key] = $value;
	}
	
	static public function getParameters(){
		return self::$parameters;
	}
	
	static public function filterUrl($key){
		$n = round(count($key)/2);
		for ($i = 0; $i < $n ; $i++) {
			if(isset($key[$i*2+1])&&in_array($key[0], self::$restModels)){
				self::setParameters($key[$i*2], $key[$i*2+1]);
			} else {
				self::setParameters($key[$i*2], null);
			}
		}
		return array(array_shift($key));
	}
	
	static public function setModel($model){
		array_push(self::$restModels, $model);
	} 
}