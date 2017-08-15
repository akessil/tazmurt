<?php


	class Functions {
	
		static function str_random($length){
			
    			$alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
    			
    			return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
		}
		
		static function redirect ($page) {
			
		     	header("Location: $page");
		     	
		     	exit();
		     			
		}
		
		static function getAuth() {
			
			$options=["restrection_msg"=> "Vous n'avez pas le droit d'accéder à cette page",
                                "connexion_msg"=>"Vous etes connecté",
                                "faild_connexion_msg"=>"Identifiant ou mot de passe incorrecte ",
                                "logout_msg"=>"Vous etes deconnecté"
                                
                                ];
			return new Auth(Session::getInstance(),$options);
					
		}
		static function getEvent() {
			
			$options=["restrection_msg"=> "Vous n'avez pas le droit d'accéder à cette page",
                                "connexion_msg"=>"Vous etes connecté",
                                "faild_connexion_msg"=>"Identifiant ou mot de passe incorrecte ",
                                "logout_msg"=>"Vous etes deconnecté"
                                
                                ];
			return new Event(Session::getInstance());
					
		}
	
	}
