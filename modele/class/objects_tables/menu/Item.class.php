<?php
	class Item extends Element {

		protected $elements=array();

		//---methodes -------

		/**
		*adds the element <code>if </code> doesn't exists in this item , nothing to do if it exists
		*@param $e : the element to add
		*/
		public function addElement(Element $e){

			$this->array_push($e);
		}

		/**
		*tels <code>if</code>any element in this item have the same name given in parameter 
		**/
		public function nameIsIn(string $name){
			foreach ($this->elements as $element) {
				if($element->getName()==$name){
					return true;
				}
			}
			return false;
		}

		/**
		*tels <code>if</code>any element in this item have the same name given in parameter 
		**/
		public function urlIsIn(string $url){
			foreach ($this->elements as $element) {
				if($element->getURL()==$url){
					return true;
				}
			}
			return false;

		}


		/**
		*removes  the element <code>if</code> it exists and returns it , 
		*@param $name : the name of element to remove 
		*/
		public function removeElement(string $name){
			$element_exists=false;
			foreach (this->$elements as $index => $element) {

				if($element->getName()==$name){
					$e=$element ;
					array_splice($this->elements,$index,1); // we remove the element 
					$element_exists=true;
					return $e;
				}
			}
			//if the element doesn't exists we make exception
			if(!$element_exists){
				throw new NotFind("not find element which named $name");
			}
		}


		/**
		*@return (string) the html code of this item
		*/
		public function toHTML(){
			$HTML_code="<div> <div class=\"tete\"> <a href=$this->getURL()> $this->getName()</a></div> <ul>";
			foreach ($this->elements as $element) {
				$HTML_code.="<li>".$element->toHTML()."</li>\n"; //toHTML which writen in Element class
			}
			$HTML_code.="</ul></div>";
		}

		//-------geters --------

		/**
		*@return array of elements 
		*/
		public function getAllElements(){
			return $this->items;
		}

		/**
		*@param $name : the name of item to return 
		*@return the first item found with the name given in parameter , <code> and null if </code> no  item with the name given 
		*/
		public function getItem(string $name){
			foreach ($this->items as $key => $item) {
				if($name==$item->getName()){
					return $item;
				}
			}
		}

	}
?>