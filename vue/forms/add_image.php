<?php require_once '../../vue/inc/header.php';?>


		<h1> ajouter une image </h1>

		<form  method="post" action="#">

		 <div class="form-group">
			<label for="title"> Titre : </label><input type="text" name="title"  class="form-control" id="title"/>
		</div>

		<div class="form-group">
			<label for="image"> charger l'image </label><input type="file" name="image" id="image" class="form-control" />
		<div>

		<div class="form-group">
			<label for="comment"> Commentaire : </label><input type="textarea" name="comment" id="comment" class="form-control"/>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">valider </button>
		</div>

		</form>


<?php require_once '../../vue/inc/footer.php';?>