<?php
use Router\Router;
use Rest\Rest;
use Viewer\Viewer;
class UserController
{
	public function index(){
		return  $this->formatter(__METHOD__);
	}
	
	public function create(){
		return  $this->formatter(__METHOD__);
	}
	
	public function destroy(){
		return  $this->formatter(__METHOD__);
	}
	
	public function update(){
		return  $this->formatter(__METHOD__);
	}
	
	public function show(){
		return  $this->formatter(__METHOD__);
	}
	
	private function formatter($method){
		$restParams = Rest::getParameters();
		$out = [];
		if(!empty($restParams)){
			$tmp = [];
			foreach ($restParams as $k=>$v){
				$tmp[] = $k.'='.$v;
			}
			$out[] = 'Rest Parameters: '.implode('&', $tmp);
		}
		
		$urlParams = Router::getParameters();
		if(!empty($urlParams)){
			$tmp = [];
			foreach ($urlParams as $k=>$v){
				$tmp[] = $k.'='.$v;
			}
			$out[] = 'Url Parameters: '.implode('&', $tmp);
		}
		$out[] = "Class $method";
		return Viewer::show('rest-messages',implode('<br>', $out));
	}
}