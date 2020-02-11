<?php
$SQL = "SELECT * FROM personnes WHERE pid IN (SELECT pid FROM inscriptions WHERE eid = ?)";
$stmt = $db->prepare($SQL);
$pers = $stmt->execute([$_GET['eid']]);

$SQL = "SELECT * FROM itypes";
$st = $db->prepare($SQL);
$typ = $st->execute();

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
	<h2>Nouvelle participation</h2><br>
	<form method="post" class="form-horizontal">
<?php
if($event['type'] == "ferme") // Liste des personnes inscrites si l'événement est fermé
{
?>		
		<div class="form-group">
			<div class="col-sm-2">
				<label for="inputPid" class="control-label">Personne</label>
			</div> <!-- col-sm-2 -->
			<div class="col-xs-4">
				<select name="pid" class="form-control" id="inputPid">
					<?php
					while(($pers = $stmt->fetch()))
					{
					?>
					<option value="<?= $pers['pid'] ?>"><?= htmlspecialchars($pers['nom']) . " " . htmlspecialchars($pers['prenom']) ?></option>	
					<?php
					}
					?>
				</select>
			</div> <!-- col-xs-4 -->
		</div> <!-- form-group -->
<?php
}
else // Saisie du nom et prénom si l'événement est ouvert
{
?>
		<div class="form-group">
			<div class="col-sm-2">
				<label for="inputLastname" class="control-label">Nom</label>
			</div> <!-- col-sm-2 -->
			<div class="col-xs-4">
				<input type="text" name="nom" class="form-control" id="inputLastname" placeholder="Nom" size="20" required value="<?= $data['nom'] ?? "" ?>">
			</div> <!-- col-xs-4 -->
		</div> <!-- form-group -->

		<div class="form-group">
			<div class="col-sm-2">
				<label for="inputFirstname" class="control-label">Prénom</label>
			</div> <!-- col-sm-2 -->
			<div class="col-xs-4">
				<input type="text" name="prenom" class="form-control" id="inputFirstname" placeholder="Prénom" size="20" required value="<?= $data['prenom'] ?? "" ?>">
			</div> <!-- col-xs-4 -->
		</div> <!-- form-group -->
<?php
}
?>
		<div class="form-group">
			<div class="col-sm-2">
				<label for="inputCategory" class="control-label">Justificatif</label>
			</div> <!-- col-sm-2 -->
			<div class="col-xs-4">
				<select name="tid" class="form-control" id="inputCategory">
					<?php
					while(($typ = $st->fetch()))
					{
					?>
					<option value="<?= $typ['tid'] ?>" <?php if(isset($data['tid']) && $data['tid'] == $typ['tid']){ ?> selected <?php } ?>><?= htmlspecialchars($typ['nom']) ?></option>
					<?php
					}
					?>
				</select>
			</div> <!-- col-xs-4 -->
		</div> <!-- form-group -->

		<div class="form-group">
			<div class="col-sm-2">
				<label for="inputValue" class="control-label">Valeur</label>
			</div> <!-- col-sm-2 -->
			<div class="col-xs-4">
				<input type="text" name="valeur" class="form-control" id="inputValue" placeholder="Valeur" size="60" required value="<?= $data['valeur'] ?? "" ?>">
			</div> <!-- col-xs-4 -->
		</div> <!-- form-group -->

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-primary">Valider</button>
			</div> <!-- col-sm-offset-2 col-sm-10 -->
		</div> <!-- form-group -->
	</form>
	<br><span><a href="../events/events_list.php" role="button" class="btn btn-default">Retour aux événements</a></span>
</div> <!-- container -->
