<?php require_once '../../vue/inc/header.php';?>


		<h1> ajouter un client </h1>
		<form class="form-group" method="post" action="">
		
		 <div class="form-group">
			<label for="name"> Nom : </label><input type="text" name="name" required="required" class="form-control" id="name" />
		</div>
		
		<div class="form-group">
			<label for="phone"> Tel : </label><input type="tel" name="phone" id="phone" class="form-control" pattern="^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$"/>
		</div>

		<div class="form-group">
			<label for="email"> E-mail : </label><input type="email" name="email" id="email" class="form-control"/>
		</div>

		<div class="form-group">
			<label for="adress"> Adresse : </label><textarea rows="3" cols="40" id="adress" name="adress"></textarea>
		<div>

				<div class="form-group">
			<button type="submit" class="btn btn-primary">valider </button>
		</div>

		</form>


<?php require_once '../../vue/inc/footer.php';?>
