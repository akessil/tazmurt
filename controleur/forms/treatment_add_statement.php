<?php require_once '../inc/header.php';?>


		<h1> ajouter une facture </h1>
		<form  method="post" action="#">
		 <div class="form-group">
			<label for="title"> Titre: </label><input type="text" name="title" required="required" class="form-control" id="title"/>
		</div>
		<div class="form-group">
			<label for="comment"> Commentaire : </label><input type="textarea" name="coment" id="comment" class="form-control"/>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">valider </button>
		</div>
		</form>


<?php require_once '../inc/footer.php';?>