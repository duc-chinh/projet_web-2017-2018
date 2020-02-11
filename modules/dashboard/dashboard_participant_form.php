<div class="container">
	<h2>Tableau de bord de <?= htmlspecialchars($name['nom']) . " " . htmlspecialchars($name['prenom']) ?></h2>
	<h3>Liste des participations</h3>
<?php
if($st->rowCount() == 0) // S'il n'y a aucune participation
{
	echo "<p>" . htmlspecialchars($name['nom']) . " " . htmlspecialchars($name['prenom']) . " ne participe à aucun événement !</p>";
}
else // Affichage du tableau si oui
{
?>
	<p style="text-align: right">Trier par: <a href="dashboard_participant.php?pid=<?= $_GET['pid']?>&sort=date">Date</a> | <a href="dashboard_participant.php?pid=<?= $_GET['pid']?>&sort=intitule">Événement</a></p> <!-- Possibilité de tri -->
	<div class="table-responsive">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Événement</th>
					<th>Date de participation</th>
					<th>Catégorie</th>
					<th>Type</th>
					<th>Responsable</th>
				</tr>
			</thead>
			<tbody>

<?php
	while($row = $st->fetch())
	{
?>
				<tr>
					<td><?= htmlspecialchars($row['intitule']) ?></td>
					<td><?= htmlspecialchars($row['date']) ?></td>
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
	<h3>Liste des événements où <?= htmlspecialchars($name['nom']) . " " . htmlspecialchars($name['prenom']) ?> est inscrit(e) mais ne participe pas</h3>
<?php
if($stmt->rowCount() == 0) // S'il n'y a aucun événement
{
	echo "<p>" . htmlspecialchars($name['nom']) . " " . htmlspecialchars($name['prenom']) . " participe à tous les événements !</p>";
}
else // Affichage du tableau si oui
{
?>
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>Événement</th>
				<th>Date de début</th>
				<th>Date de fin</th>
				<th>Type</th>
				<th>Catégorie</th>
			</tr>
		</thead>
		<tbody>

<?php
	while($res = $stmt->fetch())
	{
?>
			<tr>
				<td><?= htmlspecialchars($res['intitule']) ?></td>
				<td><?= htmlspecialchars($res['dateDebut']) ?></td>
				<td><?= htmlspecialchars($res['dateFin']) ?></td>
				<td><?php if($res['type'] == "ferme"){ echo "<p style=\"color: red\">Fermé</p>"; }
						  else{ echo "<p style=\"color: green\">Ouvert</p>"; } ?></td>
				<td><?= htmlspecialchars($res['categorie']) ?></td>
			</tr>
<?php
	}
?>
		</tbody>
	</table>
<?php
}
?>
	<br><span><a href="dashboard.php" role="button" class="btn btn-default">Retour au tableau général</a></span>
	<span><a href="../participants/participants_list.php" role="button" class="btn btn-success">Retour aux personnes</a></span>
</div> <!-- container -->