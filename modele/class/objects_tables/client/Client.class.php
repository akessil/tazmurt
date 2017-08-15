<?php
	class Client{

		//-------- attributes --------
		protected $name;
		protected $id;
		protected $adress;
		protected $phone1;
		protected $phone2;
		protected $email;
		protected $dateCreation;
		protected $projects;

		//-------- Creator------
		public function __construct($name,$dateCreation){
			$this->name=$name;
			$this->dateCreation=$dateCreation;
			$this->projects= array();
		} 

		//-------- Seters -------------
		public function setName($name){
			$this->name=$name;
		}
		public function setAdress($adress){
			$this->adress=$adress;
		}

		public function setPhone1($phone){
			$this->phone1=$phone;
		}
		public function setPhone2($phone){
			$this->phone2=$phone;
		}

		public function setEmail($email){
			$this->email=$email;
		}

		public function setId($id){
			$this->id=$id;
		}
		//---------- Geters -------------
		public function getName(){
			return $this->name;
		}

		public function getId(){
			return $this->id;
		}

		public function getDateCreation(){
			return $this->dateCreation;
		}

		public function getAdress(){
			return $this->adress;
		}

		public function getPhone1(){
			return $this->phone1;
		}

		public function getEmail(){
			return $this->email;
		}
		public function getPhone2(){
			return $this->phone2;
		}

		public function removeProject($project){
			foreach ($projects as $index=>$prj) {
				if($prj->getId()==$project->getId()){
					array_splice($this->projects,$index,1);
					return $project;
				}
			}
			return null;
		}

		public function addProject($project){
			array_push($this->projects,$project);
		}

		//------- other methodes -----------
		public function toHTML(){
			$name=$this->getName();
			$id=$this->getId();
			$adress=$this->getAdress();
			$phone=$this->getPhone1();
			$email=$this->getEmail();
			$dateCreation=$this->getdateCreation();

			$client='<div class="client" id='."client".$id.'><span class="clientName">'.$name.'</span><span class="clientAdress">'.$adress.'</span><span class="clientPhone">'.$phone.'</span><span class="clientEmail">'.$email.'</span></div>';
			return $client;
		}

	}

	//
	/*$c=new Client("koceila",'19/12/2016',788, 'CH H 25 , Res H.Boucher , Cité Scientifique , Villeneuve d\'Ascq 59650',null,'koko.ouik@yahoo.fr');
	echo $c->toHTML();*/
?>