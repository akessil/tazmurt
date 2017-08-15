<?php

	class DataBase {
	
		private $bdd;
	
		public function __construct($login, $password, $database_name, $host= 'localhost'){
			try{
			$this->bdd = new PDO("mysql:host=$host;dbname=$database_name;charset=utf8", $login, $password);
    			$this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    			//$this->bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
    		}
    		catch(Exception $e){

    			echo 'Error : '.$e->getMessag();

    		}
		
		}
	
		public function query($query,$params= false){
			//si il y a des parametre
			if($params){
				
				$result=$this->bdd->prepare($query);
			
				$result->execute($params);
			
			//sinon on evnvoie la requette directement
			
			}else{
			
				$result=$this->bdd->query($query);
			
			}
			return $result;
		
		}

		public function lastInsertId($table){
			return $this->bdd->lastInsertId($table);
		}
	
	}

?>
