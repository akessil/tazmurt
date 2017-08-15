<?php
	require_once "Manager.class.php";
	require_once "ArticleManager.class.php";
	require_once "InformationCompanyManager.class.php";
	require_once "../../../objects_tables/client/Quote.class.php";
	require_once "../../../objects_tables/client/Article.class.php";
	require_once "../../../objects_tables/client/informationCompany.class.php";
	require_once "../../connection/Connection.class.php";
	class QuoteManager extends Manager{
		protected $quoteArticleTable="quote_contains_article";
		protected $quoteInformationTable="quote_contains_information";
		protected $articleManager;
		protected $informationManager;

		public function __construct($connection){
			parent::__construct($connection);
			$this->table="quote";
			$this->articleManager= new ArticleManager($connection);
			$this->informationManager= new InformationCompanyManager($connection);
		}

		public function getById($id){
			$query="select * from ".$this->table." where id_quote=?";
			$result=$this->db->query($query,array($id));
			$c=$result->fetch();
			if($c){
				$quote=new Quote();
				$quote->setId($id);
				$quote->setTitle($c['title']);
				$quote->setComments($c['comments']);
				$quote->setNote($c['note']);
				$quote->setDateCreation($c['date_creation']);
				$quote->setDateLastModification($c['date_last_modification']);
				$quote->setProject($c['project']);
				return $quote;
			}	
		}

		public function insert($quote){

				$title=$quote->getTitle(); 
				$comments=$quote->getComments();
				$note=$quote->getNote();
				$dateCreation=$quote->getDateCreation();
				$dateLastModification=$quote->getDateLastModification();
				$project=$quote->getProject();

			$query="insert into ".$this->table."(title,comments,note,date_creation,date_last_modification, project) values(?,?,?,?,?,?)";
			$this->db->query($query,array($title,$comments,$note,$dateCreation,$dateLastModification,$project));
			
			$id=$this->getLastInsertId();
			return $id;
		}

		public function remove($id_quote){
			$articles_id=$this->getAllArticlesId($id_quote);
			$informations_id=$this->getAllInformationsId($id_quote);

			$remove_refences_images="delete from ".$this->quoteArticleTable." where the_quote = ? ";
			$this->db->query($remove_refences_images,array($id_quote)); 

			$remove_refences_images="delete from ".$this->quoteInformationTable." where the_quote = ? ";
			$this->db->query($remove_refences_images,array($id_quote)); 

			$query="delete from ".$this->table." where id_quote=?";
			$this->db->query($query,array($id_quote));

		}


		public function update($quote){
			$id=$quote->getId();
			$title=$quote->getTitle();
			$comments=$quote->getComments();
			$note=$quote->getNote();
			$dateCreation=$quote->getDateCreation();
			$dateLastModification=$quote->getDateLastModification();
			$project=$quote->getProject();
			$query="update ".$this->table."  set  title=?, comments=?, note=?, date_creation=?, date_last_modification=?, project=?  where id_quote=?" ;
			$this->db->query($query,array($title,$comments,$note,$dateCreation,$dateLastModification,$project,$id));
		}

		public function getAllInformations($quote_id){
			$list_id=$this->getAllInformationsId($quote_id);
			$list_informations=[];
			$i=0;
			while($i<lenght($list_id)){
				$list_informations[$i]=$this->informationManager->getById($list_id[$i]);
				$i+=1;
			}
			return $list_informations;
		}

	
	
		private function getAllInformationsId($id_quote){
			$query=" select the_information from ".$this->quoteInformationTable." where the_quote= ? ";
			$result=$this->db->query($query,array($id_quote));

			$list_id=[];
			$i=0;
			while($line=$result->fetch()){
				$list_id[$i]=$line['the_information'];
				$i+=1;
			}
			return $list_id;
		}

		public function getAllArticles($quote_id){
			$list_id=$this->getAllArticlesId($quote_id);
			$list_articles=[];
			$i=0;
			while($i<lenght($list_id)){
				$list_articles[$i]=$this->articleManager->getById($list_id[$i]);
				$i+=1;
			}
			return $list_articles;
		}

		/**
		*returns all ids of images of this album
		*/
		private function getAllArticlesId($id_quote){
			$query=" select the_article from ".$this->quoteArticleTable." where the_quote= ? ";
			$result=$this->db->query($query,array($id_quote));

			$list_id=[];
			$i=0;
			while($line=$result->fetch()){
				$list_id[$i]=$line['the_article'];
				$i+=1;
			}
			return $list_id;
		}

		public function addInformation($quote,$information){
			$quote_id=$quote->getId();

			//insert the information into the table informationCompany($this->image_manager->table)
			$information_inserted_id=$this->informationManager->insert($information);

			
			//insert the bill and information references 
			$insert_references = "insert into ".$this->quoteInformationTable."(the_quote,the_information) values(?,?)";
			$this->db->query($insert_references,array($quote_id,$information_inserted_id));

			//add the information to the bill
			$information->setId($information_inserted_id);
			$quote->addInformation($information);
		}

		public function addArticle($quote,$article){
			$quote_id=$quote->getId();

			//insert the information into the table informationCompany($this->image_manager->table)
			$article_inserted_id=$this->articleManager->insert($article);
			
			//insert the bill and information references 
			$insert_references = "insert into ".$this->quoteArticleTable."(the_quote,the_article) values(?,?)";
			$this->db->query($insert_references,array($quote_id,$article_inserted_id));

			//add the information to the bill
			$article->setId($article_inserted_id);
			$quote->addArticle($article);
		}

		public function removeInformation($quote,$information){
			$quote_id=$quote->getId();
			$information_id=$information->getId();
			
			$remove_references="delete from ".$this->quoteInformationTable." where the_qute= ? and the_information = ?";
			$this->db->query($remove_references,array($quote_id,$information_id));

			$quote->removeInformation($information);

		}

		public function removeArticle($quote,$article){
			$quote=$quote->getId();
			$article_id=$article->getId();
			
			$remove_references="delete from ".$this->quoteArticleTable." where the_quote= ? and the_article = ?";
			$this->db->query($remove_references,array($quote_id,$article_id));

			$this->articleManager->remove($article_id);

			$bill->removeArticle($article);

		}

		public function removeByProject($id_project){
			$quotes_id= $this->getAllQuotesIdByProject($id_project);
			$i=0;
			while($i<count($quotes_id)){
				$this->remove($quotes_id[$i]);
				$i+=1;
			}
		}

		private function getAllQuotesIdByProject($id_project){
			$query=" select id_quote from ".$this->table." where project = ? ";
			$result=$this->db->query($query,array($id_project));

			$list_id=[];
			$i=0;
			while($line=$result->fetch()){
				$list_id[$i]=$line['id_quote'];
				$i+=1;
			}
			return $list_id;
		}


	}

	
	// $manager=new QuoteManager(new Connection());
	// $quote=new Quote();
	// $quote->setTitle("titre pour test");
	// $quote->setComments("commentaire de test");
	// $quote->setNote("note de teste");
	// $quote->setDateCreation(date("Y-m-d H:i:s"));
	// $quote->setDateLastModification(date("Y-m-d H:i:s"));
	// $quote->setProject(1);

	// $id=$manager->insert($quote);
	
	// $quote2=$manager->getById($id);
	
	// $quote2->setTitle("c'est juste moi");
	
	// $manager->update($quote2);

	// $article = new Article("1er article dans bill","unité de test");
	// $manager ->addArticle($quote2,$article);


?>