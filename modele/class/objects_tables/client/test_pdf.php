<?php
	require_once('Statement.class.php');
			$options=array('nom'=>'ouikene','prenom'=>'koceila','date'=>'28/08/2016','ok'=>'012356','slogan'=>'vous fliciter la vie','logo'=>'20160530_151733_HDR.jpg','nameCompany'=>'EAOP','title'=>'devis du gaz',"totalEnFrancais"=>"trois milles cent quatre-vingt" ,"monnaie"=>"€","TVA"=>17,"remarque"=>"nous somme a votre service ");

		$articles = array(new Article('Vane d\'arret diam 16',3,350),new Article("Vane d'arret diam",1,1000),new Article("coucou sahitou",10,302.36));

		$st=new Statement(12,$articles,$options);
		
		$html="<!DOCTYPE HTML>
					<html>
						<head>
							<meta charset='utf-8' />
							<link href='style.css' rel='stylesheet' />
						</head>
						<body>
					";

		$html.=$st->toHTML()."<a href='statement_pdf.php' >pdf</a> </body></html>";
		$stream=fopen("statement.html", "w");
		fwrite($stream, $html);
		fclose($stream);
		header('Location:statement.html');
?>