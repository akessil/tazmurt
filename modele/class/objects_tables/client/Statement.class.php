<?php
	require_once("Client.class.php");
	require_once("Article.class.php");
	require_once '../../../dompdf-master/autoload.inc.php' ;
	use Dompdf\Dompdf;

	class Statement{

		//--------- attributes ---------
		protected $options = array();
		protected $articles=array(); // the liste of articles (type:Article)
		protected $id;
		protected $project;

		//------ Creator -------
		public function __construct($id=null,$articles= array(),$options=array()){
			$this->options=$options;
			$this->articles=$articles;
			$this->id=$id;
		}

		//----------- Seters --------
		public function setId($id){
			$this->id=$id;
		}

		public function setProject($project){
			$this->project=$project;
		}

		/**
		* sets the table of articles (type:Article) given in parameter to the attribute articles
		*@param $articles : array of articles (type:Article)
		*/
		public function setArticles($articles){
			$this->articles=$articles;
		}

		/**
		* sets the array of options given to the attribute options 
		*@param $options : array of options [option=>value]
		*/
		public function setOptions($options){
			$this->options=$options;
		}


		//----------- Geters -------------
		public function getId(){
			return $this->id;
		}

		public function getProject(){
			return $this->project;
		}

		public function getAllOptions(){
			return $this->options;
		}

		public function getAllArticles(){
			return $this->articles;
		}

		public function getOption($option){
			if(isset($this->options[$option])){
				return $this->options[$option];
			}
			return null;
		}

		public function getArticleByName($name){
			foreach ($articles as $article) {
				if($article->getName()==$name){
					return $article;
				}
			}
			return null;
		}

		public function getArticleById($id){
			foreach ($articles as $article) {
				if($article->getId()==$id){
					return $article;
				}
			}
			return null;
		}
		//------------ other methodes -----

		public function addOption($option,$value){
			$this->options[$option]=$value;
		}

		public function addArticle(Article $article ){
			array_push($this->articles, $article);
		}

		/**
		*removes the article which have the same name given in parameter
		*@param $name : (String) the name of the article to remove
		*/
		public function removeArticle($name){
			foreach ($articles as $index=>$article) {
				if($article->getName()==$name){
					array_splice($this->artcles,$index,1);
					return $article;
				}
			}
			return null;
		}

		public function removeOption($option){
			foreach ($this->options as $key => $value) {
				if($key==$option){
					$this->options=array_diff_assoc($this->options, array($key=>$value)); 
					return $value;
				}
			}
			return null;
		}

		public function toHTML(){
			$logo=$this->getOption("logo");//it's the logo for the company (it's a string , exactely a path to one image)
			$slogan=$this->getOption("slogan");
			$nameCompany=$this->getOption("nameCompany");
			$title=$this->getOption("title");// the title of this statement
			$TVA=$this->getoption("TVA");// le taux de TVA qaund la facture a été crée 
			$monnaie=$this->getOption("monnaie");
			$totalEnFrancais=$this->getOption("totalEnFrancais");//chifres du total en français 
			$remarque=$this->getOption("remarque");
			$otherOptions=array_diff_key($this->getAllOptions(),array("logo"=>$logo,"slogan"=>$slogan,"nameCompany"=>$nameCompany,"title"=>$title,"TVA"=>$TVA,"monnaie"=>$monnaie,"remarque"=>$remarque,"totalEnFrancais"=>$totalEnFrancais,));
			$total=0;
			
			//-------- head Statement ---------
			$statement='<div id='."statement".$this->getId().'><div id="header">';

			if($logo !=null){
				$statement.=' <img alt="logo" src'."=".$logo.' id="logo"/>';
			}

			$statement.='<strong id="slogan">'.$slogan.'</strong> <strong id="nameCompany" >'.$nameCompany.'</strong></div>';

			//---------- Body Statement -----------

			$statement.='<div id="body" >';
			$statement.='<h1 id="statement_title">'.$title.'</h1>'; //title

			$statement.='<ul id="statement_options">'; //---- the options ----
			foreach ($otherOptions as $option => $value) {
				$statement.='<li>'.$option.' : '.$value.'</li>';
			}
			$statement.='</ul>';

			         //---table of articles---------
			$statement.='<table id="statement_articles"> <thead><tr><th>Article</th><th>Quentité</th><th>Prix unitaire </th><th>Totaux</th></tr></thead>'; 
			foreach ($this->articles as $article) {
				$statement.=$article->toHTML(true);
				$total+=$article->total();
			}
			$statement.="</table>";

			//------- Totaux ---------

			$totaux='<div id="totaux"> <div id="PHT">'. $total*(100-$TVA)/100 . '</div> <div id="TVA" > '.$TVA.' % </div>'.' <div id="total" >'.$total.'</div> </div>';

			$statement.=$totaux;

			//--------- le total en francais ----------
			$total='<div id="totalENFrancais" >'.$totalEnFrancais.' '.$monnaie.'</div>';
			$statement.=$total;

			//-------- remaque ---------------------
			$remarque=$total='<div id="remarque">'.$remarque.'</div>';
			$statement.=$remarque;

			$statement.='</div>';
			return $statement;

		}

		public static function toPDF($html){
			
			$dompdf=new Dompdf();
			
			$dompdf->load_Html($html);
			
			$dompdf->set_paper('A4','landscape');
			
			//Render the HTML as PDF
			$dompdf->render();
			$dompdf->set_base_path('');
			//echo file_get_contents('statement.html');
			//output the generated pdf
			return $dompdf->stream(null,array('Attachement'=>1));
		}

	}


		
		
?>

