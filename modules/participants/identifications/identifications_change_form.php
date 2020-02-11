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
	<h2>Justificatif de <?= htmlspecialchars($row['nom']) . " " . htmlspecialchars($row['prenom']) ?></h2><br/>
	<form method="post" class="form-horizontal">
		<div class="form-group">
			<div class="col-sm-2">
				<label for="inputCategory" class="control-label">Type</label>
			</div> <!-- col-sm-2 -->
			<div class="col-xs-4">
				<select name="tid" class="form-control" id="inputCategory" disabled>
					<option value="<?= $row['tid'] ?>" selected><?= htmlspecialchars($row['type']) ?></option>
				</select> <!-- select -->
			</div> <!-- col-xs-4 -->
		</div> <!-- form-group -->

		<div class="form-group">
			<div class="col-sm-2">
				<label for="inputName" class="control-label">Valeur</label>
			</div> <!-- col-sm-2 -->
			<div class="col-xs-4">
				<input type="text" name="valeur" class="form-control" id="inputName" placeholder="Nom" size="30" required value="<?= htmlspecialchars($row['valeur']) ?>"></td>
			</div> <!-- col-xs-4 -->
		</div> <!-- form-group -->

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-primary">Valider</button>
			</div> <!-- col-sm-offset-2 col-sm-10 -->
		</div> <!-- form-group -->
	</form>
	<br><span><a href="identifications_list.php?pid=<?= $_GET['pid'] ?>" role="button" class="btn btn-default">Retour aux justificatifs</a></span>
</div> <!-- container -->
