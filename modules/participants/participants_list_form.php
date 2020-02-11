<div class="container">
	<h2>Liste des participants</h2>
<?php
if($stmt->rowCount() == 0) // S'il n'y a aucune personne
{
	echo "<p>Il n'y a aucune personne !</p>";
}
else // Affichage du tableau si oui
{
	$i = 0;
?>
	<div class="table-responsive">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Nom et prénom</th>
					<th>Modifier</th>
					<th>Supprimer</th>
					<th>Tableau de bord</th>
				</tr>
			</thead>
			<tbody>
<?php
	while(($row = $stmt->fetch()))
	{
?>
				<tr>
					<td><?= $row['pid'] ?></td>
					<td><a href="identifications/identifications_list.php?pid=<?= $row['pid'] ?>"><?= htmlspecialchars($row['nom']) . " " . htmlspecialchars($row['prenom']) ?></a></td>
					<td><a href="participants_change.php?pid=<?= $row['pid'] ?>" role="button" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span></a></td>
					<td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?= $i ?>">
							<span class="glyphicon glyphicon-trash"></span>
						</button>
					</td> <!-- Modal de suppression -->
					<td><a href="../dashboard/dashboard_participant.php?pid=<?= $row['pid'] ?>" role="button" class="btn btn-primary"><span class="glyphicon glyphicon-tasks"></span></a></td>
				</tr>
<?php
		require("participants_delete_form.php"); // Formulaire de suppression
		$i++;
	}
?>
			</tbody>
		</table>
	</div> <!-- table-responsive -->
<?php
}
?>
	<span><a href="participants_add.php" role="button" class="btn btn-success">Ajouter une personne</a></span>
</div> <!-- container -->