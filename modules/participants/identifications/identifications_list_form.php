<div class="container">
	<h2>Liste des justificatifs de <?= htmlspecialchars($name['nom']) . " " . htmlspecialchars($name['prenom']) ?></h2>
<?php
if($stmt->rowCount() == 0) // S'il n'y a aucun justificatif
{
	echo "<p>" . htmlspecialchars($name['nom']) . " " . htmlspecialchars($name['prenom']) . " n'a aucun justificatif !</p>";
}
else // Affichage du tableau si oui
{
	$i = 0;
?>
	<div class="table-responsive">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Type d'identification</th>
					<th>Valeur</th>
					<th>Modifier</th>
					<th>Supprimer</th>
				</tr>
			</thead>
			<tbody>
<?php
	while(($row = $stmt->fetch()))
	{
?>
				<tr>
					<td><?= htmlspecialchars($row['type']) ?></td>
					<td><?= htmlspecialchars($row['valeur']) ?></td>
					<td><a href="identifications_change.php?pid=<?= $_GET['pid'] ?>&tid=<?= $row['tid'] ?>" role="button" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span></a></td>
					<td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?= $i ?>">
							<span class="glyphicon glyphicon-trash"></span>
						</button></td> <!-- Modal de suppression -->
				</tr>
<?php
		require("identifications_delete_form.php"); // Formulaire de suppression
		$i++;
	}
?>
			</tbody>
		</table>
	</div> <!-- table-responsive -->
<?php
}
?>
	<span><a href="identifications_add.php?pid=<?= $_GET['pid'] ?>" role="button" class="btn btn-success">Ajouter un justificatif</a></span>
	<span style="margin-right: 0"><a href="../participants_list.php" role="button" class="btn btn-primary">Retour aux personnes</a></span>
</div> <!-- container -->
