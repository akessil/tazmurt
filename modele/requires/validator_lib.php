
<?php

	function validateName($name,$db,$table,$error_alphanumerique_msg,$error_is_uniq_msg){
		if(!empty($_POST['name'])){
		
			$validator->isAlphanumeriq('name',$error_alphanumerique_msg);
			
			if($validator->isValid()){
			
				$validator->isUniq('name',$db,'clients',$error_is_uniq_msg"ce pseudo existe déja, choisissez un autre");
			}
		}
	}
?>