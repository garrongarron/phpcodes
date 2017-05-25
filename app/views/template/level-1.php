@extend( 'template/level-0'  )

@section('title')
level -1
@stop

@section('content')
@parent
<div style="background-color: #0f0;">Content of level #-1 <?php echo __FILE__;?> </div>
	@yield('new')	
		
@stop


