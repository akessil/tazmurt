<?php
	require_once "Manager.class.php";
	require_once "ArticleManager.class.php";
	require_once "InformationCompanyManager.class.php";
	require_once "../../../objects_tables/client/Bill.class.php";
	require_once "../../../objects_tables/client/Article.class.php";
	require_once "../../../objects_tables/client/informationCompany.class.php";
	require_once "../../connection/Connection.class.php";
	class BillManager extends Manager{
		
		protected $billArticleTable="bill_contains_article";
		protected $billInformationTable="bill_contains_information";
		protected $articleManager;
		protected $informationManager;

		public function __construct($connection){
			parent::__construct($connection);
			$this->table="bill";
			$this->articleManager= new ArticleManager($connection);
			$this->informationManager=new InformationCompanyManager($connection);
		}

		public function getById($id){
			$query="select * from ".$this->table." where id_bill=?";
			$result=$this->db->query($query,array($id));
			$c=$result->fetch();
			if($c){
				$bill=new Bill();
				$bill->setId($id);
				$bill->setTitle($c['title']);
				$bill->setDiscount($c['discount']);
				$bill->setComments($c['comments']);
				$bill->setNote($c['note']);
				$bill->setDateCreation($c['date_creation']);
				$bill->setDateLastModification($c['date_last_modification']);
				$bill->setProject($c['project']);
				return $bill;
			}	
		}

		public function insert ($bill){
				$billNumber = $bill->getBillNumberInYear();
				$dateValidation=$bill->getDateValidation();
				$isValidated=$bill->getIsValidated();
				$title=$bill->getTitle(); 
				$discount=$bill->getDiscount();
				$comments=$bill->getComments();
				$note=$bill->getNote();
				$dateCreation=$bill->getDateCreation();
				$dateLastModification=$bill->getDateLastModification();
				$project=$bill->getProject();

			$query="insert into ".$this->table."(bill_number_in_year,date_validation,is_validated,title,discount,comments,note,date_creation,date_last_modification, project) values(?,?,?,?,?,?,?,?,?,?)";
			$this->db->query($query,array($billNumber,$dateValidation,$isValidated,$title,$discount,$comments,$note,$dateCreation,$dateLastModification,$project));
			
			$id=$this->getLastInsertId();
			return $id;
		}

		public function update($bill){
			$billNumber = $bill->getBillNumberInYear();
			$dateValidation=$bill->getDateValidation();
			$isValidated=$bill->getIsValidated();
			$id=$bill->getId();
			$title=$bill->getTitle();
			$discount = $bill->getDiscount();
			$comments=$bill->getComments();
			$note=$bill->getNote();
			$dateCreation=$bill->getDateCreation();
			$dateLastModification=$bill->getDateLastModification();
			$project=$bill->getProject();
			$query="update ".$this->table."  set  bill_number_in_year =?, date_validation=?, is_validated=? ,title=?, discount=?,comments=?, note=?, date_creation=?, date_last_modification=?, project=?  where id_bill=?" ;
			$this->db->query($query,array($billNumber,$dateValidation,$isValidated,$title,$discount,$comments,$note,$dateCreation,$dateLastModification,$project,$id));
		}

		public function remove($id_bill){
			$articles_id=$this->getAllArticlesId($id_bill);
			$informations_id=$this->getAllInformationsId($id_bill);

			$remove_refences_articles="delete from ".$this->billArticleTable." where the_bill = ? ";
			$this->db->query($remove_refences_articles,array($id_bill)); 

			$remove_refences_informations="delete from ".$this->billInformationTable." where the_bill = ? ";
			$this->db->query($remove_refences_informations,array($id_bill)); 

			$query="delete from ".$this->table." where id_bill=?";
			$this->db->query($query,array($id_bill));

		}	

		public function getAllInformations($bill_id){
			$list_id=$this->getAllInformationsId($bill_id);
			$list_informations=[];
			$i=0;
			while($i<lenght($list_id)){
				$list_informations[$i]=$this->informationManager->getById($list_id[$i]);
				$i+=1;
			}
			return $list_informations;
		}

		/**
		*returns all ids of images of this album
		*/
		private function getAllInformationsId($id_bill){
			$query=" select the_information from ".$this->billInformationTable." where the_bill= ? ";
			$result=$this->db->query($query,array($id_bill));

			$list_id=[];
			$i=0;
			while($line=$result->fetch()){
				$list_id[$i]=$line['the_information'];
				$i+=1;
			}
			return $list_id;
		}

		public function getAllArticles($bill_id){
			$list_id=$this->getAllArticlesId($bill_id);
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
		private function getAllArticlesId($id_bill){
			$query=" select the_article from ".$this->billArticleTable." where the_bill= ? ";
			$result=$this->db->query($query,array($id_bill));

			$list_id=[];
			$i=0;
			while($line=$result->fetch()){
				$list_id[$i]=$line['the_article'];
				$i+=1;
			}
			return $list_id;
		}

		public function addInformation($bill,$information){
			$bill_id=$bill->getId();

			//insert the information into the table informationCompany($this->image_manager->table)
			$information_inserted_id=$this->informationManager->insert($information);

			
			//insert the bill and information references 
			$insert_references = "insert into ".$this->billInformationTable."(the_bill,the_information) values(?,?)";
			$this->db->query($insert_references,array($bill_id,$information_inserted_id));

			//add the information to the bill
			$information->setId($information_inserted_id);
			$bill->addInformation($information);
		}

		public function addArticle($bill,$article){
			$bill_id=$bill->getId();

			//insert the information into the table informationCompany($this->image_manager->table)
			$article_inserted_id=$this->articleManager->insert($article);

			//insert the bill and information references 
			$insert_references = "insert into ".$this->billArticleTable."(the_bill,the_article) values(?,?)";
			$this->db->query($insert_references,array($bill_id,$article_inserted_id));

			//add the information to the bill
			$article->setId($article_inserted_id);
			$bill->addArticle($article);
		}

		public function removeInformation($bill,$information){
			$bill_id=$bill->getId();
			$information_id=$information->getId();
		
			$remove_references="delete from ".$this->billInformationTable." where the_bill= ? and the_information = ?";
			$this->db->query($remove_references,array($bill_id,$information_id));

			$bill->removeInformation($information);

		}

		public function removeArticle($bill,$article){
			$bill=$bill->getId();
			$article_id=$article->getId();
			
			$remove_references="delete from ".$this->billArticleTable." where the_bill= ? and the_article = ?";
			$this->db->query($remove_references,array($bill_id,$article_id));

			$this->articleManager->remove($article_id);

			$bill->removeArticle($article);

		}

		public function removeByProject($id_project){
			$bills_id= $this->getAllBillsIdByProject($id_project);
			$i=0;
			while($i<count($bills_id)){
				$this->remove($bills_id[$i]);
				$i+=1;
			}
		}

		private function getAllBillsIdByProject($id_project){
			$query=" select id_bill from ".$this->table." where project = ? ";
			$result=$this->db->query($query,array($id_project));

			$list_id=[];
			$i=0;
			while($line=$result->fetch()){
				$list_id[$i]=$line['id_bill'];
				$i+=1;
			}
			return $list_id;
		}




	}

	
	// $manager=new BillManager(new Connection());
	// $bill=new Bill();
	// $bill->setTitle("titre pour test");
	// $bill-> setDiscount(50.50);
	// $bill->setComments("commentaire de test");
	// $bill->setNote("note de teste");
	// $bill->setDateCreation(date("Y-m-d H:i:s"));
	// $bill->setDateLastModification(date("Y-m-d H:i:s"));
	// $bill->setProject(1);

	// $id=$manager->insert($bill);
	// $bill=$manager->getById($id);
	
	// $article = new Article("1er article dans bill","unité de test");
	// $manager ->addArticle($bill,$article);


?>