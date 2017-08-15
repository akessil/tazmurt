<?php require_once '../inc/header.php';?>


		<h1> ajouter un element </h1>
		<form  method="post" action="#">
		 <div class="form-group">
			<label for="title"> Titre: </label><input type="text" name="title" required="required" class="form-control" id="title"/>
		</div>
		<div class="form-group">
			<label for> ajouter un fichier php de controle </label><input type="file" name="file" id="file" class="form-control" />
		<div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">valider </button>
		</div>
		</form>


<?php require_once '../inc/footer.php';?>