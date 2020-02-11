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
	<h2>Type d'identification n°<?= htmlspecialchars($_GET['tid']) ?></h2><br/>
	<form class="form-horizontal" method="post">
		<div class="form-group">
			<div class="col-sm-2">
				<label for="inputName" class="control-label">Nom</label>
			</div> <!-- col-sm-2 -->
			<div class="col-xs-4">
				<input type="text" name="nom" class="form-control" id="inputName" placeholder="Type" size="30" required value="<?= htmlspecialchars($row['nom']) ?>">
			</div> <!-- col-xs-4 -->
		</div> <!-- form-group -->

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-primary">Valider</button>
			</div> <!-- col-sm-offset-2 col-sm-10 -->
		</div> <!-- form-group -->
	</form>
	<br><span><a href="itypes_list.php" role="button" class="btn btn-default">Retour aux types d'identification</a></span>
</div> <!-- container -->
