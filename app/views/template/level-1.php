@extend( 'template/level-0'  )

@section('titulo')
level -1
@stop

@section('contenido')
@parent
<div style="background-color: #0f0;">Content of level #-1</div>
	@yield('nueva')	
		
@stop


