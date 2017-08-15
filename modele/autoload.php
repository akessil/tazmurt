<?php
		if(file_exists(realpath(__DIR__."class/data_base/connection/Connection.class.php"))) {echo "coucou";}

	spl_autoload_register('app_autoload');
	
	function app_autoload($class){
		echo $class;

		if(file_exists( "class/objects_tables/client/".$class.".class.php")){
				require_once "class/objects_tables/client/".$class.".class.php";
		}
		else if(file_exists("class/objects_tables/menu/".$class.".class.php")){
				require_once "class/objects_tables/menu/".$class.".class.php";
		}
		else if(file_exists("class/data_base/manager/manager_client/".$class.".class.php")){
				require_once "class/data_base/manager/manager_client/".$class.".class.php";
		}
		else if(file_exists("class/data_base/manager/manager_menu/".$class.".class.php")){
				require_once "class/data_base/manager/manager_menu/".$class.".class.php";
		}
		else if(file_exists("class/data_base/connection/".$class.".class.php")){
				require_once "class/data_base/connection/".$class.".class.php";
		}
		else if(file_exists("class/validator/".$class.".class.php")){
				require_once "class/validator/".$class.".class.php";
		}
		
		

		/*if($a==0){
			try{
				require_once "class/objects_tables/client/".$class.".class.php";
				$a=1;
			}
			catch(Exception $e){}
		}
		if($a==0){
			try{
				require_once "class/objects_tables/menu/".$class.".class.php";
				$a=1;
			}
			catch(Exception $e){}
		}
		if($a==0){
			try {
				require_once "class/data_base/manager/manager_client/".$class.".class.php";
				$a=1;
			} catch (Exception $e) {}
		}
		if($a==0){
			try {
				require_once "class/data_base/manager/manager_menu/".$class.".class.php";
				$a=1;
			} catch (Exception $e) {}
		}
		if($a==0){
			try {
				require_once "class/data_base/connection/".$class.".class.php";
				$a=1;
			} catch (Exception $e) {}
		}
		if($a==0){
			try {
				require_once "class/validator/".$class.".class.php";
				$a=1;
			} catch (Exception $e) {}
		}*/
		

	}

?>
