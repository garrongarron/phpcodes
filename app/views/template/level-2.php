@extend( 'template/level-1'  )

@section('titulo')	
level 2
@stop

@section('contenido')
@parent
<div style="background-color: #00f;">Content of level #-2</div>
@stop

@section('nueva')
Section nested using @yield
@stop