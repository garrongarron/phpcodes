<!DOCTYPE html>
<html>
<head>
	<title>Rest Messages</title>
</head>
<body>
<h1><?php echo $data; ?></h1>
<p>Please, go to <a href="http://localhost/user">http://localhost/user</a> using <b>Advanced Rest Cliente</b> (Chome Plugin) with diferent methods as 'get', 'put', 'delete', 'post'</p>
<h3>Other Urls</h3>
<a href="http://localhost/user/123">http://localhost/user/123</a><br>
<a href="http://localhost/user/show">http://localhost/user/show</a> (Aditional Method)<br>
<a href="http://localhost/user/123/claim/001">http://localhost/user/123/claim/001</a> (Nested Resources)<br>


<br>
<b>Please change 'true' by 'false'in <i>Routes.php</i></b>
<pre>
function isLogged(){
    return true;
}
</pre>
<b>It have to look like this.</b>
<pre>
function isLogged(){
    return false;
}
</pre>

</body>
</html>
