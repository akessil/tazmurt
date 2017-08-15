<?php 
	class NotFind extends Exception{

		public function __construct($message=""){
			$this->message=$message;
		}
	
	}
?>