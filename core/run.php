<?php
use Viewer\Viewer;
use Router\Router;

$data = Router::getRoute();
$string = Viewer::show($data[1], $data);
if($string!==null){
	echo $string;
} else {
	echo 'Not file found! Please try with '
    .'<a href="http://localhost/helloworld">http://localhost/helloworld</a>';
}

