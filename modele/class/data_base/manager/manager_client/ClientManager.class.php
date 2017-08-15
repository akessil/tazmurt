<?php
	require_once "ProjectManager.class.php";
	require_once "../../../objects_tables/client/Client.class.php";
	require_once "../../connection/Connection.class.php";
	require_once "Manager.class.php";
	//require_once "../../../../autoload.php";
	class ClientManager extends Manager {
		private $projectManager;

		public function __construct($connection){
			parent::__construct($connection);
			$this->table="client";
			$this->projectManager=new projectManager($connection);
		}

		public function getById($id){
			$query="select * from ".$this->table." where id_client=?";
			$result=$this->db->query($query,array($id));
			$c=$result->fetch();
			if($c){

				$name=$c['name'];
				$dateCreation=$c['date_creation'];

				$client=new Client($name,$dateCreation);
				$client->setId($c['id_client']);
				$client->setAdress($c['adress']);
				$client->setPhone1($c['phone1']);
				$client->setPhone2($c['phone2']);
				$client->setEmail($c['email']); 

				return $client;
			}	
		}

		public function insert($client){

			$name=$client->getName();
			$dateCreation=$client->getDateCreation();
			$adress=$client->getAdress();
			$phone1=$client->getPhone1();
			$phone2=$client->getPhone2();
			$email=$client->getEmail();

			$query="insert into ".$this->table."(name,date_creation,adress,phone1,phone2,email) values(?,?,?,?,?,?)";
			$this->db->query($query,array($name,$dateCreation,$adress,$phone1,$phone2,$email));

			$id=$this->getLastInsertId();
			return $id;
		}

		public function remove($id){
			$query="delete from ".$this->table." where id_client=?";
			$this->db->query($query,array($id));
		}

		public function update($client){
			$id=$client->getId();
			$name=$client->getName();
			$dateCreation=$client->getDateCreation();
			$adress=$client->getAdress();
			$phone1=$client->getPhone1();
			$phone2=$client->getPhone2();
			$email=$client->getEmail();
			$query="update ".$this->table."  set  name=?,date_creation=? , adress=? , phone1=?,phone2=? , email=?  where id_client=?" ;
			$this->db->query($query,array($name,$dateCreation,$adress,$phone1,$phone2,$email,$id));
		}

		public function getAllproject($client){
			return $projectManager->getAllByClient($client);
		}

		public function addProject($client,$project){
			$project->setClient($client->getId());
			$project_id=$projectManager->insert($project);
			$project->setId($project_id);
			$client->addProject($project);
		}
		public function removeProject($client,$project){
			$projectManager->remove($project);
			$client->removeProject($project);
		}

	}

//--------------------- test-------------
	
	// $ClientManager=new ClientManager(new Connection);

	// $client=new Client("ramdan",date("Y-m-d H:i:s"));
	// $client->setAdress("I 240 R H Boucher");
	// $client->setPhone1("0643102546");
	// $client->setPhone2(null);
	// $client->setEmail("koceila.ouikene@yahoo.fr"); 

	// $ClientManager->insert($client);

	// $id=$ClientManager->getLastInsertId();
	// $client=$ClientManager->getById($id);
	// echo $client->toHTML();


	// $client->setName("Koceila");
	// $ClientManager->update($client);
	// $client =$ClientManager->getById($id);
	// echo $client->toHTML();

	// //$ClientManager->remove($id);
	// $client=$ClientManager->getById($id);
	// var_dump($client);
	

//---------------------------------------------------------
?>