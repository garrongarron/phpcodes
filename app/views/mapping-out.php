<!DOCTYPE html>
<html>
<head>
	<title>Mapping-out</title>
</head>
<body>
<?php
use Router\Router;

echo "<h3>$data</h3>";

var_dump(Router::getRoute());
?>

<a href="http://localhost/controller">Using Controller</a>
<pre>
Route::get('/controller', 'User@init');
</pre>
<a href="http://localhost">Using Closure</a>
<pre>
Route::get('/', function(){
	return Viewer::show('mapping-out');
});
</pre>
<a href="http://localhost/method-not-found">Method not found</a>
<pre>
Route::get('/method-not-found', 'User@xxx');
</pre>
<a href="http://localhost/class-not-found">Class not found</a>
<pre>
Route::get('/class-not-found', 'EmptyFile@init');
</pre>
<a href="http://localhost/file-not-found">File not found</a>
<pre>
Route::get('/file-not-found', 'xxx@init');
</pre>

</body>
</html>

