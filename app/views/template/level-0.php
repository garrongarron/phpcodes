<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
<style type="text/css">
body{
	border: 0px;
	padding: 0px;
	margin: 0px;
}
</style>
</head>
<div>
<h1>Header</h1>
<a href="http://localhost/level-0">Level -0</a>
<a href="http://localhost/level-1">Level -1</a>
<a href="http://localhost/level-2">Level -2</a>
<a href="http://localhost/level-3">Level -3</a>
</div>
<body>
@section('content')
<div style="background-color: #f00;">Content of level #-0 <?php echo __FILE__;?> </div>
@show

<div>
@section('extra')
Section without overwriting <?php echo __FILE__;?> 
@show
</div>
<div>	
	<h2>Footer</h2>
</div>
</body>
</html>

