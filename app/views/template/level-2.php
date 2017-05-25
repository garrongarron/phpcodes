@extend( 'template/level-1'  )

@section('title')	
level -2
@stop

@section('content')
@parent
<div style="background-color: #00f;">Content of level #-2 <?php echo __FILE__;?> </div>
@stop

@section('new')
Section nested using @yield <?php echo __FILE__;?> 
@stop