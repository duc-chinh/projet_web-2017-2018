<div class="container">
	<h2>Tableau de bord de <strong>"<?= htmlspecialchars($event['intitule']) ?>"</strong></h2>
	<h3>Liste des participations</h3>
<?php
if($st->rowCount() == 0) // S'il n'y a aucune participation
{
	echo "<p>Aucune personne ne participe à l'événement !</p>";
}
else // Affichage du tableau si oui
{
?>
	<p style="text-align: right">Trier par: <a href="dashboard_event.php?eid=<?= $_GET['eid']?>&sort=date">Date</a> | <a href="dashboard_event.php?eid=<?= $_GET['eid']?>&sort=nom">Nom</a></p>
	<div class="table-responsive">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Nom et prénom</th>
					<th>Date de participation</th>
					<th>Responsable</th>
				</tr>
			</thead>
			<tbody>
<?php
	while($row = $st->fetch())
	{
?>
				<tr>
					<td><?= htmlspecialchars($row['nom']) . " " . htmlspecialchars($row['prenom']) ?></td>
					<td><?= htmlspecialchars($row['date']) ?></td>
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
	<h3>Liste des inscrits ne participant pas</h3>
<?php
if($stmt->rowCount() == 0) // S'il n'y a aucune personne
{
	echo "<p>Tous les inscrits participent à l'événement !</p>";
}
else // Affichage du tableau si oui
{
?>
	<div class="table-responsive">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Nom et prénom</th>
				</tr>
			</thead>
			<tbody>
<?php
	while($res = $stmt->fetch())
	{
?>
				<tr>
					<td><?= htmlspecialchars($res['nom']) . " " . htmlspecialchars($res['prenom']) ?></td>
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
	<br><span><a href="dashboard.php" role="button" class="btn btn-default">Retour au tableau général</a></span>
	<span><a href="../events/events_list.php" role="button" class="btn btn-success">Retour aux événements</a></span>
</div> <!-- container -->
