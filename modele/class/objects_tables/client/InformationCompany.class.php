<?php
	class InformationCompany {
		//---------------- Attributs ---------
		protected $id;
		protected $attribut;
		protected $value;
		protected $gras; /* 1 h1, 2:h2 ......6:h6 et 0 text */
		protected $showAttribut; /* afficher l'attribut dans la facture ?*/
		protected $positionOrizontal; /* 0: entete, 1: en dessous de l'entete*/
		protected $positionVertical; /* 0:a gauche et 1:  droite */
		protected $chekRemoved; 

		//------ Creator -----
		public function __construct(){

		}

		//------- Setters

		public function setId($id){
			$this->id=$id;
		}

		public function setAttribut($attr){
			$this->attribut=$attr;
		}

		public function setValue($val){
			$this->value=$val;
		}

		public function setGras($gras){
			$this->gras=$gras;
		}

		public function setShowAttribut($bol){
			$this->showAttribut=$bol;
		}

		public function setPositionOrizontal($position){
			$this->positionOrizontal=$position;
		}

		public function setPositionVertical($position){
			$this->positionVertical=$position;
		}

		public function setChekRemoved($bol){
			$this->chekRemoved=$bol;
		}

		// Getter 
		public function getId(){
			return $this->id;
		}

		public function getAttribut(){
			return $this->attribut;
		}

		public function getValue(){
			return $this->value;
		}

		public function getGras(){
			return $this->gras;
		}

		public function getShowAttribut(){
			return $this->showAttribut;
		}

		public function getPositionOrizontal(){
			return $this->positionOrizontal;
		}

		public function getPositionVertical(){
			return $this->positionVertical;
		}

		public function getChekRemoved(){
			return $this->chekRemoved;
		}
	}
?>