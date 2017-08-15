<?php

	class Validator {
		
		private $data;
		
		private $errors;
		
		public function __construct($data){
		
			$this->data= $data;
			
		}
		
		/**
		 *@param $field : the field will be verified
		 */
		private function getField($field){
		
			if(!isset($this->data[$field] )){
				return null;
			}
			return htmlspecialchars($this->data[$field]);
		}
		
		/**
		 *@param $field : the field will be verifie
		 *@param $errorMessage : the message will be display		
		*/
		public function isAlphanumeriq($field, $errorMessage){
		
			if( !preg_match('/^[a-zA-Z0-9_]+$/',$this->getField($field))){
			
			$this->errors[$field]= $errorMessage;
			
			}
		}

		/**
		 *@param $field : the field will be verifie
		 *@param $errorMessage : the message will be display		
		*/
		public function isPhone($field, $errorMessage){
			$pattern="/^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$/";

			if( !preg_match($pattern,$this->getField($field)) ){
			
			$this->errors[$field]= $errorMessage;
			
			}
		}


		
		public function isUniq($field,$db, $table, $errorMsg){
		
			$user=$db->query("select * from $table where $field= ? ",[$this->getField($field)])->fetch();
			
			if($user){
				$this->errors[$field]=$errorMsg;
			}
		
		}
		
		/**
		 *@param $field : the field will be verifie
		 *@param $errorMsg : the message will be display		
		*/
		public function isEmail($field, $errorMsg){
		
			if(!filter_var($this->getField($field),FILTER_VALIDATE_EMAIL)){
			
			$this->errors[$field]= $errorMsg;
			
			}
		}
		
		/** we use this methode generaly , whene we want verifie two adress mail or two passe word 
		 *@param $field : the first field will be verified
		 *@param $field_confirm : the second field will be verified
		 *@param $errorMsg : the message will be display		
		*/
		
		public function isConfirmed($field,$field_confirm, $errorMsg=""){
		
			$value=$this->getField($field);
		
			if(empty($value) || $value != $this->getField($field_confirm) ){
			
				$this->errors[$field]= $errorMsg;
			
			}
		}
		/* return if there is error or not*/
		public function isValid(){
		
			return empty($this->errors);
		
		}
		
		/*return array of all errors*/
		public function getErrors(){
		
			return $this->errors;
			
		}

		/**
		*@param $field : field to verifie (the name in the html file)
		*@param $extensions : extensions accepeted 
		*@param $maxsize: the max size accepeted
		*@param $error_msg: error message
		*/
		public function isFile($field,$extensions,$maxsize,$error_extension_msg,$error_size_msg="Le fichier est trop gros"){

			if (!isset($this->data[$field]) OR $this->data[$field]['error'] >0){
				$this->errors['$field']=$file['error'];
			}
			
			else if(!in_array($ext,$extensions)){
				$this->errors[$field]=$error_extension_msg;
			}

			if ($file['size'] > $maxsize){
			  $this->errors[field]=$error_size_msg;
			}
		}
		
		
	
	}
