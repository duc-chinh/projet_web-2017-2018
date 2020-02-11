<div class="container">
	<h2>Liste des événements</h2>
<?php
if($stmt->rowCount() == 0) // S'il n'y a pas d'événement
{
	echo "<p>Il n'y a aucun événement !</p>";
}
else // Affichage du tableau si oui
{
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
					<th>Participer</th>
				</tr>
			</thead>
			<tbody>
<?php
	while(($row = $stmt->fetch()))
	{
?>
				<tr>
					<td><?= htmlspecialchars($row['eid']) ?></td>
					<td><a href="../badging/badging_list.php?eid=<?= $row['eid'] ?>"><?= htmlspecialchars($row['intitule']) ?></a></td>
					<td><?= htmlspecialchars($row['description']) ?></td>
					<td><?= htmlspecialchars($row['dateDebut']) ?></td>
					<td><?= htmlspecialchars($row['dateFin']) ?></td>
					<td><?php if($row['type'] == "ferme"){ echo "<p style=\"color: red\">Fermé</p>"; }
							  else{ echo "<p style=\"color: green\">Ouvert</p>"; } ?></td>
					<td><?= htmlspecialchars($row['nom']) ?></td>
					<td><a href="../badging/badging_add.php?eid=<?= $row['eid']?>" role="button" class="btn btn-success"><span class="glyphicon glyphicon-check"></span></a></td>
				</tr>
<?php
	}
?>
			</tbody>
		</table>
	</div> <!-- table-responsive -->
<?php
}
?>
</div> <!-- container -->
