<?php
namespace Viewer;

class Viewer
{
	static public function show($view, $data = null){
		ob_start();
			require_once VIEWFOLDER.'/'.$view.'.php';
		$contenido = ob_get_contents();
		ob_end_clean();
		echo $contenido;
		return $contenido;
	}
}