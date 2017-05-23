<?php
namespace Viewer;

class Viewer
{
	static public function show($view, $data = null){
		$file = VIEWFOLDER.'/'.$view.'.php';
		if(file_exists($file)){	
			ob_start();
				require_once VIEWFOLDER.'/'.$view.'.php';
			$contenido = ob_get_contents();
			ob_end_clean();
			return $contenido;
		}else {
			return self::show('view-not-found', $file);
		}
	}
}