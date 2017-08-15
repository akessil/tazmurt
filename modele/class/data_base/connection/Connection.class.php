<?php
	require_once "DataBase.class.php";
	class Connection {
	
		static $db=null; // par defaut on est pas connecté
	
		static function getDataBase(){
			//si on est pas déja connecté à la base de donnée on se connecte
			
			if(!self::$db){
				
				self::$db= new DataBase('root','', 'aghilas');
			}
		
			return self::$db;
		
		}
	}


?>
