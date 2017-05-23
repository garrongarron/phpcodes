<?php
$directorio = getcwd().'/'.MODELFOLDER;
$models  = scandir($directorio);
$models = array_slice($models, 2);
foreach ($models as $model){
	require_once MODELFOLDER.'/'.$model;
}