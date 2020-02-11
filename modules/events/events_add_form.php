<?php
$SQL = "SELECT * FROM categories";
$stmt = $db->prepare($SQL);
$cat = $stmt->execute();

if(!empty($error)) // Affichage des erreurs
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
	<h2>Nouvel événement</h2><br>
	<form method="post" class="form-horizontal">
		<div class="form-group">
			<div class="col-sm-2">
				<label for="inputName" class="control-label">Intitulé</label>
			</div> <!-- col-sm-2 -->
			<div class="col-xs-5">
				<input type="text" name="intitule" class="form-control" id="inputName" placeholder="Nom" size="60" required value="<?= $data['intitule'] ?? "" ?>">
			</div> <!-- col-xs-5 -->
		</div> <!-- form-group -->

		<div class="form-group">
			<div class="col-sm-2">
				<label for="inputDesc" class="control-label">Description</label>
			</div> <!-- col-sm-2 -->
			<div class="col-xs-5">
				<textarea name="description" id="inputDesc" class="form-control" placeholder="Description" rows="10" cols="50"><?= $data['description'] ?? "" ?></textarea>
			</div> <!-- col-xs-5 -->
		</div> <!-- form-group -->

		<div class="form-group">
			<div class="col-sm-2">
				<label for="inputDateStart" class="control-label">Date de début</label>
			</div> <!-- col-sm-2 -->
			<div class="col-xs-4">
				<input type="text" name="dateDebut" class="form-control" id="inputDateStart" placeholder="YYYY-MM-DD hh:mm:ss" required value="<?= $data['dateDebut'] ?? "" ?>">
			</div> <!-- col-xs-4 -->
		</div> <!-- form-group -->

		<div class="form-group">
			<div class="col-sm-2">
				<label for="inputDateEnd" class="control-label">Date de fin</label>
			</div> <!-- col-sm-2 -->
			<div class="col-xs-4">
				<input type="text" name="dateFin" class="form-control" id="inputDateEnd" placeholder="YYYY-MM-DD hh:mm:ss" required value="<?= $data['dateFin'] ?? "" ?>">
			</div> <!-- col-xs-4 -->
		</div> <!-- form-group -->

		<div class="form-group">
			<div class="col-sm-2">
				<label for="inputType" class="control-label">Type:</label>
			</div> <!-- col-sm-2 -->
			<div class="col-xs-4">
				<label class="radio-inline"><input type="radio" name="type" id="inputType" value="ouvert" <?php if(isset($data['type']) && $data['type'] == "ouvert"){ ?> checked <?php } ?>>Ouvert</label>
				<label class="radio-inline"><input type="radio" name="type" id="inputType" value="ferme" <?php if(isset($data['type']) && $data['type'] == "ferme"){ ?> checked <?php } ?>>Fermé</label>
			</div> <!-- col-xs-4 -->
		</div> <!-- form-group -->

		<div class="form-group">
			<div class="col-sm-2">
				<label for="inputCategory" class="control-label">Catégorie</label>
			</div> <!-- col-sm-2 -->
			<div class="col-xs-3">
				<select name="cid" class="form-control" id="inputCategory">
					<?php
					while(($cat = $stmt->fetch()))
					{
					?>
					<option value="<?= $cat['cid'] ?>" <?php if(isset($data['cid']) && $data['cid'] == $cat['cid']){ ?> selected <?php } ?> ><?= $cat['nom'] ?></option>	
					<?php
					}
					?>
				</select>
			</div> <!-- col-xs-3 -->
		</div> <!-- form-group -->

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-primary">Valider</button>
			</div> <!-- col-sm-offset-2 col-sm-10 -->
		</div> <!-- form-group -->
	</form>
	<br><span><a href="events_list.php" role="button" class="btn btn-default">Retour aux événements</a></span>
</div> <!-- container -->
