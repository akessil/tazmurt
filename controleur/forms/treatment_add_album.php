
<?php require_once '../../modele/autoload.php';?>

<?php

	
	/*si les données sont envoyées*/
	if(!empty($_POST)){
	
		/*on recupere les messages d'erreurs dans un tableau associatif*/
		$errors=[];
		
		$db= Connexion::getDatabase();
		$validator= new Validator($_POST);

		//----------------vérification de titre ---------

		if(!empty($_POST['title'])){
		
			$validator->isAlphanumeriq('title',"le titre n'est pas valide (alphanumérique)");
		}
		
		
		// -------- vérification de l'adresse
		if(!empty($_POST["adress"])){
			$validator->isAlphanumeriq('adress',"l'adresse n'est pas valide (alphanumérique)");
		}	

		/*==============================================================================================================*/
		
		/*inscrire dans la base de donnée*/
		if($validator->isValid()){
                    
                        $title_field=filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
                        
                        $adress_field=filter_input(INPUT_POST, 'adress', FILTER_SANITIZE_STRING);
             
		     	echo'tout est bon ';
		    			    	
		}
		else{
			
			$errors=$validator->getErrors();
			
		}
	}

?>

<?php require_once '../../vue/forms/add_album.php';?>