<?php
if(!empty($error)) // Affichage des messages d'erreur
{
?>
<div class="alert alert-danger alert-dismissible fade in" style="margin-top: -30px; margin-bottom: 30px">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Attention !</strong> <?= $error ?? "" ?>
</div>
<?php
}
?>

<div class="container">
	<h2>Modification de la personne n°<?= $_GET['pid'] ?></h2><br>
	<form method="post" class="form-horizontal">
		<div class="form-group">
			<div class="col-sm-2">
				<label for="inputLastname" class="control-label">Nom</label>
			</div> <!-- col-sm-2 -->
			<div class="col-xs-4">
				<input type="text" name="nom" class="form-control" id="inputLastname" placeholder="Nom" size="30" required value="<?= htmlspecialchars($row['nom']) ?>">
			</div> <!-- col-xs-4 -->
		</div> <!-- form-group -->

		<div class="form-group">
			<div class="col-sm-2">
				<label for="inputFirstname" class="control-label">Prénom</label>
			</div> <!-- col-sm-2 -->
			<div class="col-xs-4">
				<input type="text" name="prenom" class="form-control" id="inputFirstname" placeholder="Prénom" size="30" required value="<?= htmlspecialchars($row['prenom']) ?>">
			</div> <!-- col-xs-4 -->
		</div> <!-- form-group -->

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-primary">Valider</button>
			</div> <!-- col-sm-offset-2 col-sm-10 -->
		</div> <!-- form-group -->
	</form>
	<br><span><a href="participants_list.php" role="button" class="btn btn-default">Retour aux personnes</a></span>
</div> <!-- container -->
