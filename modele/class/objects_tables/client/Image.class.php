<?php
	class Image{

		//--------- attributes ---------
		protected $title;
		protected $id;
		protected $src;
		protected $alt;
		protected $dateCreation;
		protected $dateLastModification;
		protected $comments;
		protected $width;
		protected $height;

		//------Creator ------------
		public function __construct(){
		}

		//----- Seters --------
		public function setTitle($t){
			$this->title=$t;
		}

		public function setId($id){
			$this->id=$id;
		}

		public function setSrc($p){
			$this->src=$p;
		}

		public function setAlt($alt){
			$this->alt=$alt;
		}

		public function setDateCreation($date){
			$this->dateCreation=$date;
		}
		public function setDateLastModification($date){
			$this->dateLastModification=$date;
		}

		public function setComments($c){
			$this->comments=$c;
		}

		public function setAlbum($a){
			$this->album=$a;
		}

		public function setHeight($h){
			$this->height=$h;
		}

		public function setWidth($w){
			$this->width=$w;
		}


		//---------- geters -----------
		public function getTitle(){
			return $this->title;
		}

		public function getId(){
			return $this->id;
		}

		public function getSrc(){
			return $this->src;
		}

		public function getAlt(){
			return $this->alt;
		}

		public function getDateCreation(){
			return $this->dateCreation;
		}

		public function getDateLastModification(){
			return $this->dateLastModification;
		}
		public function getComments(){
			return $this->comments;
		}


		public function getHeight(){
			return $this->height;
		}

		public function getWidth(){
			return $this->width;
		}

		//------- other methodes ------------

		public function toHTML(){
			$img='<img src="'.$this->getSrc().'" alt="'.$this->getAlt().'" id='."image".$this->getId().'"  />';
			$div='<div class="image" >';
			$div.='<h3 class="titre_image">'.$this->getTitle()."</h3>";
			$div.=$img;
			$div.='<div class="comments">'.$this->getComments()."</div>";
			return $div;
		}

	}
?>