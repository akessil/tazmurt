<?php
	class Project{
		//------- attributes ---------
		protected $name;
		protected $id;
		protected $dateBegin;
		protected $dateEnd;
		protected $dateCreation;
		protected $lastDateModification;
		protected $adress;
		protected $comments;
		protected $client; // the client id 

		protected $albums;
		protected $bills;
		protected $quotes;

		//--------- Creator ---------
		public function __construct(){

			$this->albums= array();
			$this->bills = array();
			$this->quotes= array();
		}

		//------ Seters ---------
		public function setName($name){
			$this->name=$name;
		}

		public function setId($id){
			$this->id=$id;
		}

		public function setDateBegin($date){
			$this->dateBegin=$date;
		}

		public function setDateCreation($date){
			$this->dateCreation=$date;
		}

		public function setLastDateModification($date){
			$this->lastDateModification=$date;
		}

		public function setDateEnd($date){
			$this->dateEnd=$date;
		}

		public function setAdress($adress){
			$this->adress=$adress;
		}

		public function setComments($comments){
			$this->comments=$comments;
		}

		public function setClient($client){
			$this->client = $client;
		}

		public function setAlbums($albums){
			$this->albums=$albums;
		}

		public function setBills($bills){
			$this->bills=$bills;
		}

		public function setQuotes($quotes){
			$this->quotes=$quotes;
		}
		//---------- Geters ----------
		public function getName(){
			return $this->name;
		}

		public function getId(){
			return $this->id;
		}

		public function getDateBegin(){
			return $this->dateBegin;
		}

		public function getDateEnd(){
			return $this->dateEnd;
		}

		public function getDateCreation(){
			return $this->dateCreation;
		}

		public function getLastDateModification(){
			return $this->lastDateModification;
		}

		public function getAdress(){
			return $this->adress;
		}

		public function getComments(){
			return $this->comments;
		}

		public function getClient(){
			return $this->client;
		}

		public function getBills(){
			return $this->bills;

		}

		public function getQuotes(){
			return $this->quotes;
		}

		public function getAlbums(){
			return $this->albums;
		}

		public function removeAlbum($album){
			foreach ($albums as $index=>$alb) {
				if($alb->getId()==$album->getId()){
					array_splice($this->albums,$index,1);
					return $album;
				}
			}
			return null;
		}

		public function addAlbum($album){
			array_push($this->albums,$album);
		}

		public function removeQuote($quote){
			foreach ($quotes as $index=>$q) {
				if($q->getId()==$quote->getId()){
					array_splice($this->quotes,$index,1);
					return $quote;
				}
			}
			return null;
		}

		public function addQuote($quote){
			array_push($this->quotes,$quote);
		}

		public function removeBill($bill){
			foreach ($bills as $index=>$b) {
				if($b->getId()==$bill->getId()){
					array_splice($this->bills,$index,1);
					return $bill;
				}
			}
			return null;
		}

		public function addBill($bill){
			array_push($this->bills,$bill);
		}


		//--------- other methodes ------
		public function toHTML(){
		}
	}
?>