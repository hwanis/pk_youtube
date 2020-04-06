<?php

# absolute path
define('_ROOT_PATH_', DIRECTORY_SEPARATOR.'opt'.DIRECTORY_SEPARATOR.'apache'.DIRECTORY_SEPARATOR.'htdocs'.DIRECTORY_SEPARATOR.'tang'.DIRECTORY_SEPARATOR);

function __autoload($get_class_name)
{
	$get_path_name = explode('_', $get_class_name);
	$path = $get_path_name[0];      
   //     exit;
	//$class_name = $get_path_name[1];

    //echo _ROOT_PATH_;
	
	$class_path_name = _ROOT_PATH_.DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.$get_class_name.'.php';

	if(is_readable($class_path_name))
	{		
		require_once $class_path_name;		
	}
	else
	{
		die('Not Read Class');
	}
}
