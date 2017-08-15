<?php
	class Article{

		//------Attributes--------
		protected $name ;
		protected $id;
		protected $quantity;
		protected $unit;
		protected $priceUnit=0;

		//------ Creator -----
		public function __construct($name,$unit,$priceUnit=0,$id=null){
			$this->name=$name;
			$this->id=$id;
			$this->unit=$unit;
			$this->priceUnit=$priceUnit;
		}

		//-------- Seters ------

		public function setName($name){
			$this->name=$name;
		}

		public function setId($id){
			$this->id=$id;
		}

		public function setUnit($unit){
			$this->unit=$unit;
		}

		public function setPriceUnit($priceUnit){
			$this->priceUnit=$priceUnit;
		}
		public function setQuantity($qte){
			$this->quantity=$qte;
		}


		//----------Geters---------

		public function getName(){
			return $this->name;
		}

		public function getId(){
			return $this->id;
		}

		public function getUnit(){
			return $this->unit;
		}

		public function getPriceUnit(){
			return $this->priceUnit;
		}
		public function getQuantity(){
			return $this->quantity;
		}

		//------------ other methodes --------

		public function toHTML($table=false){
			$name=$this->getName();
			$id=$this->getId();
			$quentity=$this->getQuentity();
			$price=$this->getPriceUnit();
			$total=$quentity*$price;
			
			if ($table){
				$article='<tr class="article" id='."article".$id.'><td class="name">'.$name.'</td><td class="unit">'.$unit.'</td><td class="priceUnit">'.$price.'</td><td class="total">'.$total.'</td></tr>';
			}
			else{
				$article='<div class="article" id='."article".$id.'><span class="name">'.$name.'</span><span class="unit">'.$quentity.'</span><span class="priceUnit">'.$price.'</span><span class="total">'.$total.'</span></div>';
			}
			return $article;
		}

		public function total(){
			return $this->getUnit()*$this->getPriceUnit();
		}

	}

	/*$article=new Article("robinet",3,350,12,360);
	echo "<table>".$article->toHTML(true)."</table>";*/

?>