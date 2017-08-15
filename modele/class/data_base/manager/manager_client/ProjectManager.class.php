<?php
	require_once "Manager.class.php";
	require_once "AlbumManager.class.php";
	require_once "QuoteManager.class.php";
	require_once "BillManager.class.php";


	require_once "../../../objects_tables/client/Album.class.php";
	require_once "../../../objects_tables/client/Quote.class.php";
	require_once "../../../objects_tables/client/Bill.class.php";
	require_once "../../../objects_tables/client/Project.class.php";
	require_once "../../connection/Connection.class.php";

	class ProjectManager extends Manager{

		protected $table_albums="project_contains_album" ;
		protected $albumManager;
		protected $quoteManager;
		protected $billManager;

		public function __construct($connection){
			parent::__construct($connection);
			$this->table = "project";
			$this->albumManager=new AlbumManager($this->connection);
			$this->quoteManager=new QuoteManager($this->connection);
			$this->billManager=new BillManager($this->connection);
		}

		public function getById($id){
			$query="select * from ".$this->table." where id_project=?";
			$result=$this->db->query($query,array($id));
			$a=$result->fetch();
			if($a){
				$project=new Project();
				$project->setId($a['id']);
				$project->setName($a['name']);
				$project->setDateBegin($a['date_begin']);
				$project->setDateCreation($a['date_creation']);
				$project->setLastDateModification($a['last_date_modification']);
				$project->setDateEnd($a['date_end']);
				$project->setAdress($a['adress']);
				$project->setComments($a['comments']);
				$project->setClient($a['client']);
				return $project;
			}	
		}

		public function insert($project){

			$name= $project->getName();
			$dateBegin= $project->getDateBegin();
			$dateCreation= $project->getDateCreation();
			$dateLastModification=$project->getLastDateModification();
			$dateEnd = $project->getDateEnd();
			$adress= $project->getAdress();
			$comments= $project->getComments();
			$client=$project->getClient();

			$query=" insert into ".$this->table."(name,date_begin,date_creation,date_last_modification,date_end,adress,comments,client ) values(?,?,?,?,?,?,?,?)";
			$this->db->query($query,array($name,$dateBegin,$dateCreation,$dateLastModification,$dateEnd,$adress,$comments,$client));

			$id=$this->getLastInsertId();
			$project->setId($id);
			return $id;
		}


		public function remove($id_project){
			
			$albums_id=$this->getAllAlbumsId($id_project);

			$remove_refences_albums="delete from ".$this->table_albums." where the_project = ? ";
			$this->db->query($remove_refences_albums,array($id_project));

			$i=0;
			while($i<count($albums_id)){
				$this->albumManager->remove($albums_id[$i]);
				$i+=1;
			}

			
			$query="delete from ".$this->table." where id_project = ? ";
			$project= $this->getById($id_project);

			$this->db->query($query,array($id_project));
			$this->quoteManager->removeByProject($id_project);
			$this->billManager->removeByProject($id_project);

			return $project;
		}


		public function update($project){

			$id= $project -> getId();
			$name= $project->getName();
			$dateBegin= $project->getDateBegin();
			$dateCreation= $project->getDateCreation();
			$dateLastModification=$project->getLastDateModification();
			$dateEnd = $project->getDateEnd();
			$adress= $project->getAdress();
			$comments= $project->getComments();
			$client=$project->getClient();

			$query="update ".$this->table."  set  name=?, date_begin=? , date_creation=?, date_last_modification=>?, date_end=?, adress=?,comments=?,client=?  where id_project=?" ;
			$this->db->query($query,array($name,$dateBegin,$dateCreation,$dateLastModification,$dateEnd,$adress,$comments,$client,$id));
		}


		private function getAllAlbumsId($id_project){
			$query=" select the_album from ".$this->table_albums." where the_project = ? ";
			$result=$this->db->query($query,array($id_project));

			$list_id=[];
			$i=0;
			while($line=$result->fetch()){
				$list_id[$i]=$line['the_album'];
				$i+=1;
			}
			return $list_id;
		}


		public function getAllAlbums($id_project){
			$list_id=$this->getAllAbumsId($id_album);
			$list_albums=[];
			$i=0;
			while($i<lenght($list_id)){
				$list_images[$i]=$this->albumManager->getById($list_id[$i]);
				$i+=1;
			}
			return $list_albums;
		} 


		public function addAlbum($project,$album){
			$project_id=$project->getId();


			$album_inserted_id=$this->albumManager->insert($album);

			$insert_references="insert into ".$this->table_albums." (the_project,the_album) values(?,?)";
			$this->db->query($insert_references,array($project_id,$album_inserted_id));

			$project->addAlbum($this->albumManager->getById($album_inserted_id));
		}


		public function removeAlbum($project,$album){
			$project_id=$project->getId();
			$album_id=$album->getId();

			
			$remove_references="delete from ".$this->table_albums." where the_project= ? and the_album= ?";
			$this->db->query($remove_references,array($project_id,$album_id));

			$this->albumManager->remove($album_id);

			$album->removeImage($album);

		}

		public function getAllByClient($client){
			$id_client = $client->getId();
			$query="select * from ".$this->table." where client=?";
			$result=$this->db->query($query,array($id_client));
			$projects = array();
			$a=$result->fetch();
			while($a){
				$project=new Project();
				$project->setId($a['id']);
				$project->setName($a['name']);
				$project->setDateBegin($a['date_begin']);
				$project->setDateCreation($a['date_creation']);
				$project->setLastDateModification($a['last_date_modification']);
				$project->setDateEnd($a['date_end']);
				$project->setAdress($a['adress']);
				$project->setComments($a['comments']);
				$project->setClient($a['client']);

				array_push($this->projects, $project);
				$result->fetch();
			}	

			return $projects;
		}

	}
		//-------------------------- to do ------------------
		// test this class 

		//$manager = new ProjectManager(new Connection);
		// $project = new Project ();
		// $project->setName("project 1");
		// $project->setDateCreation(date("Y-m-d H:i:s"));
		// $project->setDateBegin(date("Y-m-d H:i:s"));
		// $project->setDateEnd(date("Y-m-d H:i:s"));
		// $project->setLastDateModification(date("Y-m-d H:i:s"));
		// $project->setClient(2);
		// $project->setAdress("timizart");
		// $project->setComments("No comments");
		// var_dump($project);
		// $manager->insert($project
		//$manager->remove(1);

?>