<?php

	class Auth {
	
		private $options=[]; //les messages à afficher
		
		private $session;
		
		public function __construct ($session, $options=[]){
			
			$this->options= array_merge($this->options, $options);
			
			$this->session= $session;
		
		}
	
		public  function register($db,$username, $password, $email,$table){
		
			$pass=password_hash($password,PASSWORD_BCRYPT);
			
			$token=Functions::str_random(60);
					
			//remplir la table password
			$db->query("insert into $table (username, email, password,validation_token) values(?,?,?,?)",[$username,$email,$pass,$token])->fetch();
			
			//le dernier id inséré
						
			$user_id =$db->query("select max(id) from users")->fetch()->max;
			
    			// On envoit l'email de confirmation apré configuration du serveur
    			
		    	/*mail($_POST['email'], 'Confirmation de votre compte', "Afin de valider votre compte merci de cliquer sur ce lien\n\nhttp://local.dev/Lab/Comptes/confirm.php?id=$user_id&token=$token");*/
		    	
		    	$this->session->setFlash('success',"Afin de valider votre compte merci de cliquer sur ce lien\n\n<a href='".pathinfo($_SERVER['PHP_SELF'])['dirname']."/confirm.php?id=$user_id&token=$token'>Valider</a>");
		
		}
		
		public function confirm($db, $user_id, $token){
		
			$user = $db->query("SELECT * FROM users WHERE id = ?",[$user_id])->fetch();

			if($user && $user->validation_token == $token ){
			
			    $db->query('UPDATE users SET validation_token = NULL, validated_at = NOW() WHERE id = ?',[$user_id]);
			    
			      
    			    $this->session->write('auth', $user);
			    
			    return true;
			    
			}
			return false;
		
		}
			
		public function restrict(){
		
		  if(!$this->session->read('auth')){
		  
		      $this->session->setFlash('danger',$this->options['restrection_msg']); //"Vous n'avez pas le droit d'accéder à cette page");
		      
		      header("Location: login.php");
		      
		      exit();
		  }
		  
	    	}
                
                public function isConnect(){
                        
                        if(!$this->session->read('auth')){
                            
                            return false;
                        }
                        
                        return $this->session->read('auth');
                    }
                    
                public function connect($user){
                        
                        $this->session->write('auth',$user);
                        
                        $this->session->setFlash('success',  $this->options['connexion_msg']);
                        
                        
                    }

                public function auto_connecte($db){
                        
                        if(isset($_COOKIE['remember']) && !isConnect()){
	
			
			$remember_token= filter_input(INPUT_COOKIE, 'remember', FILTER_SANITIZE_STRING);
		
			$parts=explode("//",$remember_token); //pour recuperer l'id
		
			$user_id=$parts[0];
		
			$user=$db->query("SELECT * FROM users WHERE id= ?",[$user_id])->fetch(); //on recupére le user correspondant à ce cookie		
		
			if($user){ //si le cookie est valide
			
				$expected= $user->id."//".$user->remember_token.sha1($user->id."coucou");
			
				if($expected==$remember_token){ //on compare le cookie est le le token existant dans la base
				
					//on reconnecte le user
                                        $this->connect($user);
                                        //et on redefinie à nouveaa le cookie
					setcookie("remember",$remember_token,time()+60*60*24*7);
				}
				else{
					setcookie("remember",NULL,-1);
				}
			}
			else{	//le cookie est incorrecte
				setcookie("remember",NULL,-1);
			}
		
		
		}
                        
            }
            
                public function login($db,$username, $password, $remember= false){
                                        //on recupére l'utilisateur correspondant
                    $req=$db->query("SELECT * FROM users WHERE (username=:username OR email=:username) AND validated_at IS NOT NULL",["username"=>$username]);

                    $user=$req->fetch();
                    //on verifie si les données sont correctes
                    if($user && password_verify($password,$user->password)){

                        $this->connect($user);

                        if($remember){  //se souvenir de moi

                            $remember_token=Functions::str_random(250);

                            $db->query("UPDATE users SET remember_token= ? WHERE id= ?",[$remember_token,$user->id]);

                            setcookie("remember",$user->id."//".$remember_token.sha1($user->id."coucou"),time()+60*60*24*7);

                        }

                        header("Location: account.php");

                        exit();

                    }
                    else{

                            $this->session->setFlash("danger",  $this->options["faild_connexion_msg"]);
                    }
	                    
                }
                
                public function logout(){
                    
                    setcookie("remember",NULL,-1); //supprimer le cockie
	
                    $this->session->delete('auth'); //supprimer le user

                    $this->session->setFlash('success',  $this->options['logout_msg']);

                }
                
                public function resetPassword($db,$email){
                    
                    $user = $db->query('SELECT * FROM users WHERE email = ? AND validated_at IS NOT NULL',[$email])->fetch();

                    if($user){

                          $reset_token = Functions::str_random(60);

                          $user_id=$user->id;

                          $db->query('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?',[$reset_token, $user->id]);
			
                          $this->session->setFlash('success', "Afin de réinitialiser votre mot de passe merci de cliquer sur ce lien\n\n<a href='reset.php?id=$user_id&token=$reset_token'>Valider</a>");		  

                          header('Location: login.php');
                          exit();

                    }else{
                          $this->session->setFlash('danger', 'Aucun compte ne correspond à cet adresse');
                    }
                    
                }
            
                public function checkReset($db, $id, $token){
                
                return $db->query("SELECT * FROM users WHERE id= ? AND reset_token= ? AND reset_at > current_timestamp - interval '30 minutes'",[$id,$token])->fetch();
		
                }
                
                public function reset($db,$user, $password){

                    $pass=password_hash($password,PASSWORD_BCRYPT);
				
                    $db->query("UPDATE users SET password = ?, reset_token= NULL, reset_at= NULL WHERE id= ?",[$pass,$user->id]);		
				//et on affcihe le message
		
                    $this->session->write('auth',$user);
                    
                }
                
                public function updatePassword($db, $password){
                    
                    $user_id = $this->session->read('auth')->id;
                    
                    $pass= password_hash($password, PASSWORD_BCRYPT);
                    
                    $db->query('UPDATE users SET password = ? WHERE id = ?',[$pass,$user_id]);                   
                    
                }
            
   
                
	}
