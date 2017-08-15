<?php
	class Element {
		protected $name;
		protected $url='#';

		//---- methodes ----

		/**
		*@param $name : the name of this element or the title of this element 
		*/
		public function setName($name){
			$this->name=$name;
		}


		/**
		*@param $url : the url (link) for this element 
		*/
		public function setURL($url){
			$this->url=$url;
		}


		/**
		*return the name of this element 
		*@return String the name of this element
		*/
		public function getName(){
			return $this->name;
		}


		/**
		*return the url of this element
		*@return String the url of this element  
		*/
		public function getURL(){
			return $this->url;
		}


		/** 
		*tels <code>if</code> this element and the other given in parameter are equals
		*@param $element : the element to compare to this element
		*@return boolean <code> true if </code> the two elements are equals and <code> false if </code>they aren't, comparing the two names and the two url s 
		*/
		public function equal(Element $element){
			if($this->getName()==$element->getName() && $this->getURL()==$element->getURL()){
				return true;  
			}
			else {
				return false ; 
			}
		}

		/**
		*tels <code>if</code> the element given in parameter and this element have the same name .
		*@return boolean 
		*/
		public function sameName(Element $element){
			if($this->getName==$element->getName()){
				return true;
			}
			else{
				return false;
			}
		}

		/**
		*tels <code>if</code> the element given in parameter and this element have the same URL.
		*@return boolean 
		*/
		public function sameURL(Element $element){
			if($this->getURL()==$element->getURL()){
				return true;
			}
			else{
				return false;
			}

		}

		/**
		*@return : return the HTML code of this element 
		*/
		public function toHTML(){
			return '<a href="'.$this->getURL().'" >'. $this->getName().'</a>';
		}

	}


?>