<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8"/>
	<title> ajouter un client</title>
	<link rel="stylesheet" type="text/css" href="../../vue/css/boots.css"/>
	</head>
<body>
	<header>
		<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
        <span class="sr-only">Formulaire Exemple</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Client</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Se connecter <span class="sr-only">(current)</span></a></li>
        <li><a href="#">S'inscrire</a></li>
       
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>
		
	</header>
	<div class="container">
  <?php
        if(isset($errors) && !empty($errors)){
          foreach ($errors as $field => $error){
            echo "<div class=\"alert alert-danger\">$error</div>";
          }
        }
  ?>