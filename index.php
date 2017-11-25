<?php
require_once('lib/Common.php');
require_once('lib/DB.php');
require_once('config.php');
require_once('lib/JWT/JWT.php');

$class = $_GET['class'];
$fun = $_GET['function'];

if(isset($class)) {
	if($fun == ""){$fun = 'index';}
	if(file_exists('api/'.$class.'.php')){
		require_once('api/'.$class.'.php');
		$obj = new $class();
		if(method_exists($obj,$fun)){
			$obj->$fun();
		}else{
			not_found();
		}
	}else{
		not_found();
	}
}else {
	not_found();
}

function not_found(){
	echo "404";
}

?>