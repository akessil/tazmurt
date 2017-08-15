<?php
	require_once "Manager.class.php";
	require_once "../../../objects_tables/client/Image.class.php";
	require_once "../../connection/Connection.class.php";
	class ImageManager extends Manager{

		public function __construct($connection){
			parent::__construct($connection);
			$this->table="image";
		}

		public function getById($id){
			$query="select * from ".$this->table." where id_image=?";
			$result=$this->db->query($query,array($id));
			$c=$result->fetch();
			if($c){
				$img=new Image();
				$img->setId($id);
				$img->setDateCreation($c['date_creation']);
				$img->setTitle($c['title']);
				$img->setComments($c['comments']);
				$img->setSrc($c['src']);
				return $img;
			}	
		}

		public function insert($img){

			$path=$img->getSrc();
			$dateCreation=$img->getDateCreation();
			$title=$img->getTitle();
			$comments=$img->getComments();
			$dateLastModification=$img->getDateLastModification();
			$query="insert into ".$this->table."(src,title,date_creation,date_last_modification,comments) values(?,?,?,?,?)";
			$this->db->query($query,array($path,$title,$dateCreation,$dateLastModification,$comments));
			
			$id=$this->getLastInsertId();
			$img->setId($id);
			return $id;
		}

		public function remove($id){
			$query="delete from ".$this->table." where id_image=?";
			$this->db->query($query,array($id));
		}

		public function update($image){
		    $title=$image->getTitle();
			$src=$image->getSrc();
			$comments=$image->getComments();
			$id=$image->getId();
			$dateCreation=$image->getDateCreation();
			$dateLastModification=$image->getDateLastModification();
			$query="update ".$this->table."  set  title=?, src=?, comments=?, date_creation=?, date_last_modification=?  where id_image=?" ;
			$this->db->query($query,array($title,$src,$comments,$dateCreation,$dateLastModification,$id));
		}

	}

	
	// $manager=new ImageManager(new Connection());
	// $image=new Image();
	// $image->setTitle("moi.jpg");
	// $image->setSrc("path/path");
	// $image->setDateCreation(date("Y-m-d H:i:s"));
	// $image->setDateLastModification(date("Y-m-d H:i:s"));
	// $image->setComments("No comments ");

	// $id=$manager->insert($image);
	// $image2=$manager->getById($id);
	// echo $image2->toHTML();
	// echo var_dump($image2);
	// $image2->setTitle("c'est juste moi");
	// $manager->update($image2);
?>