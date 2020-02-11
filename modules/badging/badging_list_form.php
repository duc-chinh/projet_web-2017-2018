<div class="container">
	<h2>Liste des inscriptions de <strong><?= htmlspecialchars($row['intitule']) ?></strong></h2>
<?php
if($stmt->rowCount() == 0) // Si aucune personne n'est inscrite
{
	echo "<p>Il n'y a aucune inscription à l'événement !</p>";
}
else // Affichage du tableau si oui
{
?>
	<div class="table-responsive">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Nom et prénom</th>
					<th>Justificatif</th>
					<th>Valeur</th>
				</tr>
			</thead>
			<tbody>
<?php
	while(($res = $stmt->fetch()))
	{
?>
				<tr>
					<td><?= htmlspecialchars($res['nom']) . " " . htmlspecialchars($res['prenom']) ?></td>
					<td><?= htmlspecialchars($res['id']) ?></td>
					<td><?= htmlspecialchars($res['valeur']) ?></td>
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
	<span><a href="../events/events_list.php" role="button" class="btn btn-default">Retour aux événements</a></span>
</div> <!-- container -->
