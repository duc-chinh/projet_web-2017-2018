<div class="container">
	<h2>Résultats de la recherche <strong>"<?= htmlspecialchars($_POST['search']) ?>"</strong></h2>
<?php
if($stmt1->rowCount() == 0)
{
	echo "<p>Aucun résultat trouvé</p>";
}
else
{
?>
	<ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#event">Événements</a></li>
	</ul>

	<div class="tab-content">
		<div id="event" class="tab-pane fade in active">
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
	while(($event = $stmt1->fetch()))
	{
?>
						<tr>
							<td><?= htmlspecialchars($event['eid']) ?></td>
							<td><a href="../badging/badging_list.php?eid=<?= $event['eid'] ?>"><?= htmlspecialchars($event['intitule']) ?></a></td>
							<td><?= htmlspecialchars($event['description']) ?></td>
							<td><?= htmlspecialchars($event['dateDebut']) ?></td>
							<td><?= htmlspecialchars($event['dateFin']) ?></td>
							<td><?php if($event['type'] == "ferme"){ echo "<p style=\"color: red\">Fermé</p>"; }
									  else{ echo "<p style=\"color: green\">Ouvert</p>"; } ?></td>
							<td><?= htmlspecialchars($event['nom']) ?></td>
							<td><a href="../badging/badging_add.php?eid=<?= $event['eid']?>" role="button" class="btn btn-success"><span class="glyphicon glyphicon-check"></span></a></td>
						</tr>
<?php
	}
?>
					</tbody>
				</table>
			</div> <!-- table-responsive -->
		</div> <!-- id event -->
	</div> <!-- table-content -->
<?php
}
?>
</div> <!-- container -->
