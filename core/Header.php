<?php
namespace Header;

class Header
{
	static private $headers = [];
	
	public static function set($string){
		array_push(self::$headers, $string);
	}
	
	public static function run($body){
		foreach (self::$headers as $string){
			header($string);
		}
		echo $body;
	}
	
}