<?php
	
	require_once "Manager.class.php";
    require_once "../../../objects_tables/client/Article.class.php";
	require_once "../../connection/Connection.class.php";

	class ArticleManager extends Manager {
		public function __construct($connection){
			parent::__construct($connection);
			$this->table="article";
		}


		/*
		*$article de Type Article
		*/
		public function insert($article){
			$query="insert into ".$this->table."(name,unit,quantity,priceUnit) values(?,?,?,?)";

			$name=$article->getName();
			$unit=$article->getUnit();
			$priceUnit=$article->getPriceUnit();
			$quantity= $article->getQuantity();
			$this->db->query($query,array($name,$unit,$quantity,$priceUnit));

			$id=$this->getLastInsertId();
			return $id;
		}


		/**
		*returns the article if they are one wich have the id given in parameter else returns null
		*/
		public function getById($id){
			$query="select * from ".$this->table." where id_article=? ";

			$result =$this->db->query($query,array($id));
			$line=$result->fetch();
			if($line){
				$name=$line["name"];
				$unit=$line["unit"];
				$priceUnit=$line["priceUnit"];
				$quantity=$line['quantity'];

				$article=new Article($name,$unit,$priceUnit,$id);
				$article->setQuantity($quantity);
				return $article;
			}
		}

		/*
		*@overide 
		*/
		public function remove($id){
			$managed=$this->getById($id);

			if($managed){ //if the managered exists (the managered it was be an article or statement or image ..... all ojects )
				$query="delete from ".$this->table." where id_article=?";
				$this->db->query($query,array($id));
				return $managed; 
			}
		}

		/*
		*@overide 
		*/
		public function update($article){
			$id=$article->getId();
			$name=$article->getName();
			$unit=$article->getUnit();
			$quantity=$article->getQuantity();
			$priceUnit=$article->getPriceUnit();

			$query="update ".$this->table."  set  name=?, unit=?,priceUnit=?, quantity=? where id_article=?" ;
			$this->db->query($query,array($name,$unit,$priceUnit,$quantity,$id));
		}

}
		//---------------- tests --------------------

		// $article = new Article("Tube cuivre diam 22","metre");
		// $article->setPriceUnit=680.25;
		// $article->setQuantity(22.5);
		//$manager = new ArticleManager(new Connection());
		
		
		// $id=$manager->insert($article);
		// $article->setId($id);
		// $article->setName("titre modifié!");

		// $manager->update($article);
		//$manager->remove(21);

		// //-------------------------------------------

?>