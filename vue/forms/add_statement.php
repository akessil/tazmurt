<?php $TVA=17;//17% ?>
<?php require_once '../../vue/inc/header.php';?>

		<script src="../js/add_statement.js"></script>
		<h1> ajouter une facture </h1>
		<form  method="post" action="#">
		 <div class="form-group">
			<label for="title"> Titre: </label><input type="text" name="title" required="required" class="form-control" id="title"/>
		</div>
		<div class="form-group">
			<label for="comment"> Commentaire : </label><textarea rows="1" cols="40" id="comment" name="comment"></textarea>
		</div>

		<form method="post" action="#">
			<table id="table">

				<thead>
					<tr>
						<th> N° </th>
						<th>Designations</th>
						<th>U</th>
						<th>Qte</th>
						<th>Prix U.HT</th>
						<th>Montant</th>
					</tr>
				</thead>

				<tbody>
					<tr >
						<td class="lineNumber"><span id="N1">01</span></td>
						<td><input type="text" class="articles" name="article1" id="article1" required="required" /></td>
						<td><input type="text" name="unit1" class ="unit" value="u"/></td>
						<!--the quantity -->
						<td><input type="number" name="number1" class="number" min="0" step="any" id="number1" required="required"/></td> 

						<td><input type="text" name="price1" class="price"  id="price1" required="required"></td>
						<td class="amount" id="amount1"></td><td></td>
					</tr>
				</tbody>
			</table>

			<div id="totaux">
				<div id="PHT" > Prix H.T : <span  id="PHT_value"> </span></div>
				<div id="TVA" > TVA : <span  id="TVA_value"><?php echo $TVA." %" ; ?> </span></div>
				<div id="TTC" > TTC : <span  id="TTC_value"> </span></div>
				<label for="discount" > Remise : </label> <input type="text" name="discount" id="discount" value="0"/>
				<div id="total"> Total : <span id="total_value"></span></div>


			</div>

			<button id="add_article"><img src="../images/add_article.jpg" alt="image + add_article" width="60" height="40" /></button>
		
			<label for="totalToString">Total en Français </label><textarea name="totalToString" id="totalToString" rows="1" cols="40"></textarea>
			<label for="remarque">Remarque </label><textarea name="remarque" id="remarque" rows="1" cols="20"></textarea>
		<div class="form-group">
			<button type="submit" class="btn btn-primary">valider </button>
		</div>
		</form>
		
		
		<?php 
			var_dump($_POST);
		?>


<?php require_once '../../vue/inc/footer.php';?>