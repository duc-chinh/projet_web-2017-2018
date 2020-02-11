<div class="container">
	<h2>Liste des types d'identification</h2>
<?php
if($stmt->rowCount() == 0) // S'il n'y a aucun type d'identification
{
	echo "<p>Il n'y a aucun type d'identification !</p>";
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
					<th>Nom</th>
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
				<td><?= htmlspecialchars($row['tid']) ?></td>
				<td><?= htmlspecialchars($row['nom']) ?></td>
				<td><a href="itypes_change.php?tid=<?= $row['tid'] ?>" role="button" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span></a></td>
				<td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?= $i ?>">
						<span class="glyphicon glyphicon-trash"></span>
					</button></td> <!-- Modal de suppression -->
			</tr>
<?php
		require("itypes_delete_form.php"); // Formulaire de suppression
		$i++;
	}
?>
			</tbody>
		</table>
	</div> <!-- table-responsive -->
<?php
}
?>
	<span><a href="itypes_add.php" role="button" class="btn btn-success">Ajouter un type</a></span>
</div> <!-- container -->