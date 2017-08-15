
<?php 
	class Menu{

		protected $items =[]; // the liste of items

		//--- methodes ----

		/**
		 *@param $item : the item to add , note : use nameIsIn() 
		 */
		public function addItem (Item $item){
				array_push($this->items,$item);
		}



		/**
		*tels <code>if</code>any element in this item have the same name given in parameter 
		**/
		public function nameIsIn(string $name){
			foreach ($this->items as $item) {
				if($item->getName()==$name){
					return true;
				}
			}
			return false;
		}


		/**
		 *@param $name : the name's item to be removed (remove the first item found)
		 *@return the item removed (Item ) or null </code> if </code> the item doesn't exists 
		*/
		public function removeItem(string $name){
			$element_exists=false;
			foreach (this->$items as $index => $item) {

				if($item->getName()==$name){
					$e=$item ;
					array_splice($this->items,$index,1); // we remove the element 
					$element_exists=true;
					return $e;
				}
			}
			//if the element doesn't exists we make exception
			if(!$element_exists){
				throw new Exception("not find element which named $name");
			}

		}

		/**
		*@return the item which have the name given in parameter , returns the first element found 
		*/
		public function getItem($string $name){
			foreach ($this->items as $key => $item) {
				if($name=$item->getName()){
					return $item;
				}
			}

		}

		/**
		*@return array which contains all item 
		*/
		public function getAllItem(){
			return $this->items;
		}


		/**
		*@return the HTML code of this menu
		*/
		public function toHTML(){
			$menu="<div class=\"menu\"><ul> ";
			foreach ($this->items as $key => $item) {
				$menu.="<li>".$item->toHTML()."</li>";
			}
			$menu.="</li></div>"
		}

	}
?>