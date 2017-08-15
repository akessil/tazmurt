<?php
	require_once "Manager.class.php";
	require_once "../../../objects_tables/client/InformationCompany.class.php";
	require_once "../../connection/Connection.class.php";
	class InformationCompanyManager extends Manager{
		public function __construct($connection){
			parent::__construct($connection);
			$this->table="information_Company";
		}

		public function getById($id){
			$query="select * from ".$this->table." where id_information=?";
			$result=$this->db->query($query,array($id));
			$data=$result->fetch();
			if($c){
				$infoCompany=new InformationCompany();
				$infoCompany->setId($id);
				$infoCompany->setAttribut($data["attribut"]); 
				$infoCompany->setValue($data["value"]);
				$infoCompany->setGras($data["gras"]);
				$infoCompany->setShowAttribut($data["show_attribut"]);
				$infoCompany->setPositionOrizontal($data["position_orizontal"]);
				$infoCompany->setPositionVertical($data["position_vertical"]);
				$infoCompany->setChekRemoved($data["chek_removed"]);
				return $infoCompany;
			}	
		}

		public function insert($infoCompany){

			$attribut=$infoCompany->getAttribut();
			$value=$infoCompany->getValue();
			$gras=$infoCompany->getGras();
			$showAttribut=$infoCompany>getShowAttribut();
			$positionOrizontal=$infoCompany->getPositionOrizontal();
			$positionVertical=$infoCompany->getPositionVertical();
			$chekRemoved = $infoCompany->getChekRemoved();

			$query="insert into ".$this->table."(attribut,value,gras,showAttribut,position_rizontal,position_vertical,chek_removed) values(?,?,?,?,?,?,?)";
			$this->db->query($query,array($attribut,$value,$gras,$showAttribut,$positionOrizontal,$positionVertical,$chek_removed));
			
			$id=$this->getLastInsertId();
			return $id;
		}

		public function remove($id){
			$query="delete from ".$this->table." where id_information=?";
			$this->db->query($query,array($id));
		}

		public function update($infoCompany){
			$id=$infoCompany->getId();
			$query= "update ".$this->table." set chekRemoved=? where id_information=?";
			$this->db->query($query,array(true,$id));

			$newId=$this->insert($infoCompany);
			return newId;
		}

	}

	// //--------------- test 
	// 			$infoCompany=new InformationCompany();
	// 			$infoCompany->setAttribut("TEST"); 
	// 			$infoCompany->setValue("Test 01");
	// 			$infoCompany->setGras(2);
	// 			$infoCompany->setShowAttribut(true);
	// 			$infoCompany->setPositionOrizontal(1);
	// 			$infoCompany->setPositionVertical(0);
	// 			$infoCompany->setChekRemoved(false); 
	// 			var_dump($infoCompany);
	// 			$manager= new InformationCompanyManager(new Connection());
	// 			$manager->insert($infoCompany);
?>