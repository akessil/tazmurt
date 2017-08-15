<?php
	require_once "Manager.class.php";
	require_once "ImageManager.class.php";

	require_once "../../../objects_tables/client/Image.class.php";
	require_once "../../../objects_tables/client/Album.class.php";
	require_once "../../connection/Connection.class.php";

	class AlbumManager extends Manager{

		protected $table_images ;// la table ou sont stockées les références des images de cet album 
		protected $image_manager;
		
		public function __construct($connection){
			parent::__construct($connection);
			$this->table="album";
			$this->table_images="album_contains_image";
			$this->image_manager=new ImageManager($this->connection);
		}

		public function getById($id){
			$query="select * from ".$this->table." where id_album=?";
			$result=$this->db->query($query,array($id));
			$a=$result->fetch();
			if($a){
				$album=new Album();
				$album->setDateCreation($a['date_creation']);
				$album->setTitle($a['title']);
				$album->setComments($a['comments']);
				$album->setDateLastModification($a['date_last_modification']);
				return $album;
			}	
		}

		public function insert($album){

			$title=$album->getTitle();
			$comments=$album->getComments();
			$dateCreation=$album->getDateCreation();
			$dateLastModification=$album->getDateLastModification();
			

			$query="insert into ".$this->table."(title,comments,date_creation, date_last_modification) values(?,?,?,?)";
			$this->db->query($query,array($title,$comments,$dateCreation,$dateLastModification));

			$id=$this->getLastInsertId();
			$album->setId($id);
			return $id;
		}


		public function remove($id_album){
			$images_id=$this->getAllImagesId($id_album);

			// remove all lines which contains the refernce of this album and all refernces of images of this album ($id given)
			$remove_refences_images="delete from ".$this->table_images." where the_album = ? ";
			$this->db->query($remove_refences_images,array($id_album)); 

			// remove all images of this album ($id)
			$i=0;
			while($i<count($images_id)){
				$this->image_manager->remove($images_id[$i]);
				$i+=1;
			}

			// remove the album wich have the $id given 
			$query="delete from ".$this->table." where id_album = ? ";
			$this->db->query($query,array($id_album));

		}


		public function update($album){

		}


		/**
		*returns all ids of images of this album
		*/
		private function getAllImagesId($id_album){
			$query=" select the_image from ".$this->table_images." where the_album = ? ";
			$result=$this->db->query($query,array($id_album));

			$list_id=[];
			$i=0;
			while($line=$result->fetch()){
				$list_id[$i]=$line['the_image'];
				$i+=1;
			}
			return $list_id;
		}




		/*
		*returns all images (Type:Image) of this album
		*/
		public function getAllImages($id_album){
			$list_id=$this->getAllImagesId($id_album);
			$list_images=[];
			$i=0;
			while($i<lenght($list_id)){
				$list_images[$i]=$this->image_manager->getById($list_id[$i]);
				$i+=1;
			}
			return $list_images;
		} 




		/** adds the image given to the album given , note -> beffore we must exicute insert($album)
		*@param $album : Type Album , the album must have an id and and maust exists in the table ($this->table)
		*@param $image : Type Image
		*/
		public function addImage($album,$image){
			$album_id=$album->getId();

			//insert the image into the table image($this->image_manager->table)
			$image_inserted_id=$this->image_manager->insert($image);

			
			//insert album and image references 
			$insert_references="insert into ".$this->table_images." (the_album,the_image) values(?,?)";
			$this->db->query($insert_references,array($album_id,$image_inserted_id));

			//add the image to the album
			$album->addImage($this->image_manager->getById($image_inserted_id));
		}



		/** removes the image given to the album given 
		*@param $album : Type Album , the album must have an id and  must exists in the table ($this->table)
		*@param $image : Type Image , the image must have an id and must exists in the $this->image_manager->table
		*/
		public function removeImage($album,$image){
			$album_id=$album->getId();
			$image_id=$image->getId();

			//remove the album and image refernces from $this->table_images
			$remove_references="delete from ".$this->table_images." where the_album = ? and the_image = ?";
			$this->db->query($remove_references,array($album_id,$image_id));

			//remove the image from the table image($this->image_manager->table)
			$this->image_manager->remove($image_id);

			// remove the image from the album

			$album->removeImage($image);

		}

	}

	//------------------ tests ---------------------
	/*
	$album_manager=new AlbumManager(new Connection());
    $image=new Image("plage.jpg","c'est a Azfoun",date("Y-m-d H:i:s"),"c'était une journée inoubliable");
    $album=new Album("mon premier album","les vacances",date("Y-m-d H:i:s"),date("Y-m-d H:i:s"));
    $album_manager->insert($album);
    $album_manager->addImage($album,$image);
    */
    //-----------------------------------------------

?>

 
  
  