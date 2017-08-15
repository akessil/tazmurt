<?php
	require_once("Image.class.php");
	class Album{

		//-------- attributes ----------
		protected $title ;
		protected $id;
		protected $comments;
		protected $dateCreation;
		protected $dateLastModification ;

		protected $images;

		//-----Creator -----------
		public function __construct($title=null,$comments=null,$dateCreation=null,$dateLastModification,$id=null){
			$this->title=$title;
			$this->id=$id;
			$this->comments=$comments;
			$this->dateCreation=$dateCreation;
			$this->dateLastModification=$dateLastModification;
			$this->images=array( );
		}


		//------ Seters -----------

		public function setTitle($t){
			$this->title=$title;
		}

		public function setId($id){
			$this->id=$id;
		}

		public function setComments($c){
			$this->comments=$c;
		}

		public function setDateCreation($date){
			$this->dateCreation=$date;
		}

		public function setDateLastModification($date){
			$this->dateLastModification=$date;
		}


		/**adds the image given to this Album 
		*@param $image : Type(Image)
		*/
		public function addImage($image){
			array_push($this->images,$image);
		}

		/** removes the image ( that has the same id with the image given)  from $this->images  , and return the image removed
		*@param $image : Type (Image) must have an id
		*/
		public function removeImage($image){
			
			foreach ($this->images as $index => $img) {

				if($image->getId()==$img->getId()){
					array_splice($this->images,$index,1); // we remove the element 
					return $img;
				}
			}
		}

		//----------- Geters -----------

		public function getTitle(){
			return $this->title;
		}

		public function getId(){
			return $this->id;
		}

		public function getComments(){
			return $this->comments;
		}

		public function getDateCreation(){
			return $this->dateCreation;
		}

		public function getDateLastModification(){
			return $this->dateLastModification;
		}

		public function getAllImages(){
			return $this->images ;
		}

	}
?>