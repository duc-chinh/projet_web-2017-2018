<div class="container">
	<h2>Liste des événements</h2>
<?php
if($stmt->rowCount() == 0) // S'il n'y a aucun événement
{
	echo "<p>Il n'y a aucun événement !</p>";
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
					<th>Description</th>
					<th>Date de début</th>
					<th>Date de fin</th>
					<th>Type</th>
					<th>Catégorie</th>
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
					<td><?= htmlspecialchars($row['eid']) ?></td>
					<td>
						<a href="../dashboard/dashboard_event.php?eid=<?= $row['eid'] ?>"><?= htmlspecialchars($row['intitule']) ?></a>
					</td>
					<td><?= htmlspecialchars($row['description']) ?></td>
					<td><?= htmlspecialchars($row['dateDebut']) ?></td>
					<td><?= htmlspecialchars($row['dateFin']) ?></td>
					<td><?php if($row['type'] == "ferme"){ echo "<p style=\"color: red\">Fermé</p>"; }
							  else{ echo "<p style=\"color: green\">Ouvert</p>"; } ?></td>
					<td><?= htmlspecialchars($row['nom']) ?></td>
					<td><a href="events_change.php?eid=<?= $row['eid']?>" role="button" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span></a></td>
					<td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?= $i ?>">
							<span class="glyphicon glyphicon-trash"></span>
						</button>
					</td> <!-- Modal de suppression -->
				</tr>
<?php
		require("events_delete_form.php"); // Formulaire de suppression
		$i++;
	}
?>
			</tbody>
		</table>
	</div>
<?php
}
?>
	<span><a href="events_add.php" role="button" class="btn btn-success">Ajouter un événement</a></span>
</div> <!-- container -->
