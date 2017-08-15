<?php
	abstract class Manager{
		protected $connection ;
		protected $db ;
		protected $table;

		protected function __construct($connection){
			$this->connection=$connection;
			$this->db=$this->connection->getDataBase();
		}

		public function getLastInsertId(){
	    	$request_id="select LAST_INSERT_ID() from ".$this->table;
			$id= $this->db->lastInsertId($this->table);
			return $id;
	    }

	    /*
		*removes the article if they are one and returns it , else it does nothing and returns null  
		*/
	    abstract function remove($id);

	    /*
	     *the managed must have an id (not null) and must exists in database 
	     */
		abstract function update($managed);

	    abstract function getById($id);
	    abstract function insert($managed);

	}
?>