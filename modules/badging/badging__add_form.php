<?php
for($i = 1; $i <= $nb; $i++) // Affichage des messages d'erreur
{ 
	if(!empty($error[$i]))
	{
?>
<div class="alert alert-danger alert-dismissible fade in" style="margin-top: -30px; margin-bottom: 30px">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Attention !</strong> <?= $error[$i] ?? "" ?> (formulaire n°<?= $i ?>)
</div>
<?php
	}
}
?>

<div class="container">
<?php
for($i = 1; $i <= $nb; $i++) // Affichage des formulaires
{
	$SQL = "SELECT * FROM evenements";
	$stmt = $db->prepare($SQL);
	$evt = $stmt->execute();

	$SQL = "SELECT * FROM itypes";
	$st = $db->prepare($SQL);
	$typ = $st->execute();
?>
	<h2>Nouvelle participation n°<?= $i ?></h2><br>
	<form method="post" class="form-horizontal">
		<div class="form-group">
			<div class="col-sm-2">
				<label for="inputEid<?= $i ?>" class="control-label">Evénement</label>
			</div> <!-- col-sm-2 -->
			<div class="col-xs-4">
				<select name="eid<?= $i ?>" class="form-control" id="inputEid<?= $i ?>">
					<?php
					while(($evt = $stmt->fetch()))
					{
					?>
					<option value="<?= $evt['eid'] ?>" <?php if(isset($data[$i]['eid']) && $data[$i]['eid'] == $evt['eid']){?> selected <?php } ?>>
						<?= htmlspecialchars($evt['intitule']) ?></option>	
					<?php
					}
					?>
				</select>
			</div> <!-- col-xs-4 -->
		</div> <!-- form-group -->

		<div class="form-group">
			<div class="col-sm-2">
				<label for="inputLastname<?= $i ?>" class="control-label">Nom</label>
			</div> <!-- col-sm-2 -->
			<div class="col-xs-4">
				<input type="text" name="nom<?= $i ?>" class="form-control" id="inputLastname<?= $i ?>" placeholder="Nom" size="20" required value="<?= $data[$i]['nom'] ?? "" ?>">
			</div> <!-- col-xs-4 -->
		</div> <!-- form-group -->

		<div class="form-group">
			<div class="col-sm-2">
				<label for="inputFirstname<?= $i ?>" class="control-label">Prénom</label>
			</div> <!-- col-sm-2 -->
			<div class="col-xs-4">
				<input type="text" name="prenom<?= $i ?>" class="form-control" id="inputFirstname<?= $i ?>" placeholder="Prénom" size="20" required value="<?= $data[$i]['prenom'] ?? "" ?>">
			</div> <!-- col-xs-4 -->
		</div> <!-- form-group -->

		<div class="form-group">
			<div class="col-sm-2">
				<label for="inputCategory<?= $i ?>" class="control-label">Justificatif</label>
			</div> <!-- col-sm-2 -->
			<div class="col-xs-4">
				<select name="tid<?= $i ?>" class="form-control" id="inputCategory<?= $i ?>">
					<?php
					while(($typ = $st->fetch()))
					{
					?>
					<option value="<?= $typ['tid'] ?>" <?php if(isset($data[$i]['tid']) && $data[$i]['tid'] == $typ['tid']){?> selected <?php } ?>>
						<?= htmlspecialchars($typ['nom']) ?></option>
					<?php
					}
					?>
				</select>
			</div> <!-- col-xs-4 -->
		</div> <!-- form-group -->

		<div class="form-group">
			<div class="col-sm-2"> <!-- col-sm-2 -->
				<label for="inputValue<?= $i ?>" class="control-label">Valeur</label>
			</div>
			<div class="col-xs-4">
				<input type="text" name="valeur<?= $i ?>" class="form-control" id="inputValue<?= $i ?>" placeholder="Valeur" size="60" required value="<?= $data[$i]['valeur'] ?? "" ?>">
			</div> <!-- col-xs-4 -->
		</div> <!-- form-group -->
<?php
}
?>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-primary">Valider</button>
			</div> <!-- col-sm-offset-2 col-sm-10 -->
		</div> <!-- form-group -->
	</form>
	<br><span><a href="../events/events_list.php" role="button" class="btn btn-default">Retour aux événements</a></span>
</div> <!-- container -->
