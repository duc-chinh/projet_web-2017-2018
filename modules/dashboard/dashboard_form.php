<div class="container">
	<h2>Tableau de bord</h2>
<?php
if($stmt->rowCount() == 0) // S'il n'y a aucune participation
{
	echo "<p>Il n'y a aucune personne participant aux événements !</p>";
}
else // Affichage du tableau si oui
{
?>
	<p style="text-align: right">Trier par: <a href="dashboard.php?sort=date">Date</a> | <a href="dashboard.php?sort=intitule">Événement</a> | <a href="dashboard.php?sort=nom">Nom</a></p> <!-- Possibilité de tri -->
	<div class="table-responsive">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Événement</th>
					<th>Nom et prénom</th>
					<th>Date de participation</th>
					<th>Catégorie</th>
					<th>Type</th>
					<th>Responsable</th>
				</tr>
			</thead>
			<tbody>
<?php
	while(($row = $stmt->fetch()))
	{
?>
			<tr>
				<td><a href="dashboard_event.php?eid=<?= $row['eid'] ?>"><?= htmlspecialchars($row['intitule']) ?></a></td>
				<td><a href="dashboard_participant.php?pid=<?= $row['pid'] ?>"><?= htmlspecialchars($row['nom']) . " " . htmlspecialchars($row['prenom']) ?></a></td>
				<td><a href="dashboard_date.php?date=<?= date("Y-m-d",strtotime($row['date'])) ?>">
						<?= htmlspecialchars($row['date']) ?></a>
				</td>
				<td><?= htmlspecialchars($row['categorie']) ?></td>
				<td><?php if($row['type'] == "ferme"){ echo "<p style=\"color: red\">Fermé</p>"; }
						  else{ echo "<p style=\"color: green\">Ouvert</p>"; } ?></td>
				<td><?= htmlspecialchars($row['login']) ?></td>
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
