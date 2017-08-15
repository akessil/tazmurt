<?php require_once '../../modele/autoload.php';?>

<?php

	
	/*si les données sont envoyées*/
	if(!empty($_POST)){
	
		/*on recupere les messages d'erreurs dans un tableau associatif*/
		$errors=[];
		
		$db= Connexion::getDatabase();
		$validator= new Validator($_POST);

		//----------------vérification de name ---------
		if(!empty($_POST['name'])){
		
			$validator->isAlphanumeriq('name',"Votre pseudo n'est pas valide (alphanumérique)");
			
			if($validator->isValid()){
			
				$validator->isUniq('name',$db,'clients',"ce pseudo existe déja, choisissez un autre");
			}
		}
		//------------------------------- vérification de l'email ---------------
		if(!empty($_POST['email'])){

			$validator->isEmail('email',"Votre email n'est pas valide");

			if($validator->isValid()){

				$validator->isUniq('email',$db,'clients',"cet email existe déja, choisissez un autre");
			}
		}
		
		// -----------------  vérification de num phone --------------
		if(!empty($_POST['phone'])){

			$validator->isPhone('phone','le numéro de téléphone est incorrecte ! choisissez un autre ');
		}
		if($validator->isvalid()){

			$validator->isUniq('phone',$db,'clients','le numéro existe déja pour un autre client à qui vous pouvez le modifier ou le supprimer , utilisez la barre de recherche pour trouver le client en question ,ou choisissez un autre numéro pour le nouveau client');
		}

		if(!empty($_POST['adress'])){
			$validator->isAlphanumeriq('adress','l\'adresse doit etre en alphanumérique ' );
		}

		//--------------- vérification adresse -----------
		if(!empty($_POST["adress"])){
			$validator->isAlphanumeriq('adress',"l'adresse n'est pas valide (alphanumérique)");
		}
		/*==============================================================================================================*/
		
		/*inscrire dans la base de donnée*/
		if($validator->isValid()){
                    
                        $name_field=filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
                        
                        $phone_field=filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
                        
                        $email_field=filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                        $adress_field=filter_input(INPUT_POST,'adress',FILTER_SANITIZE_STRING);
			
				//Functions::getAuth()->register($db, $username_field, $password_field, $email_field, "users");	
		    	
		     	// On redirige l'utilisateur vers la page de login avec un message flash	     	
		     		     	
		     	echo'tout est bon ';
		    			    	
		}
		else{
			
			$errors=$validator->getErrors();
			
		}
	}

?>

<?php require_once '../../vue/forms/add_client.php';?>

