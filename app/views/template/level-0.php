<!DOCTYPE html>
<html>
<head>
	<title>@yield('titulo')</title>
<style type="text/css">
body{
	border: 0px;
	padding: 0px;
	margin: 0px;
}
</style>
</head>
<body>
@section('contenido')
<div style="background-color: #f00;">Content of level #-0</div>
@show

@section('pepo')
Section without redefinition!
@show
<div>	
<a href="http://localhost/level-0">Level -0</a><br>
<a href="http://localhost/level-1">Level -1</a><br>
<a href="http://localhost/level-2">Level -2</a><br>
</div>
</body>
</html>
