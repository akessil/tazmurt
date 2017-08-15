
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

		//------------------  vérification de l'image -----

		if(!empty($_FILES['image'])){
			echo 'coucou je suis la ';
			$validator2=new Validator($_FILES);
			$validator2->isFile('image',['png','jpg','gif','jpeg'],2000,'le fichier n\'est pas une image');
			echo '<script>alert(\'coucou\')</script>';
		}

		
		//--------------- vérification de commentaire

		if(!empty($_POST['comment'])){
			$validator->isAlphanumeriq('comment','le commentaire doit etre en alphanumérique ' );
		}


		/*==============================================================================================================*/
		
		/*inscrire dans la base de donnée*/
		if($validator->isValid()){
                    
                        $name_field=filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
                        

                        $coment_field=filter_input(INPUT_POST,'comment',FILTER_SANITIZE_STRING);
			
				//Functions::getAuth()->register($db, $username_field, $password_field, $email_field, "users");	
		    	
		     	// On redirige l'utilisateur vers la page de login avec un message flash	     	
		     		     	
		     	echo'tout est bon ';
		    			    	
		}
		else{
			
			$errors=$validator->getErrors();
			
		}
	}

?>

<?php require_once '../../vue/forms/add_image.php';?>