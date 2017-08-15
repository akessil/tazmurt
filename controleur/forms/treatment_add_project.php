<?php require_once '../inc/header.php';?>


		<h1> ajouter un projet </h1>
		<form  method="post" action="#">
		 <div class="form-group">
			<label for="name"> Nom : </label><input type="text" name="name" required="required" class="form-control" id="name"/>
		</div>
		<div class="form-group">
			<label for="adress"> Adresse : </label><input type="text" name="adress" id="adress" class="form-control" />
		<div>
		<div class="form-group">
			<label for="comment"> Commentaire : </label><input type="textarea" name="coment" id="comment" class="form-control"/>
		</div>
		<div class="form-group">
			<label for="dateBegin"> Date de debut de projet : </label><input type="date" name="dateBegin" id="dateBegin" class="form-control"/>
		</div>
		<div class="form-group">
			<label for="dateEnd"> Date de debut de projet : </label><input type="date" name="dateEnd" id="dateEnd" class="form-control"/>
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary">valider </button>
		</div>
		</form>


<?php require_once '../inc/footer.php';?>