
<?php require_once '../../vue/inc/header.php';?>


		<h1> ajouter un album </h1>
		<form  method="post" action="#">
		 <div class="form-group">
			<label for="title"> Titre: </label><input type="text" name="title" required="required" class="form-control" id="title"/>
		</div>
		<div class="form-group">
			<label for="comment"> Commentaire : </label><textarea rows="3" cols="40" id="comment" name="comment"></textarea>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">valider </button>
		</div>
		</form>


<?php require_once '../../vue/inc/footer.php';?>