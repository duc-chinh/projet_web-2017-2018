<div class="container">
	<h2>Résultats de la recherche <strong>"<?= htmlspecialchars($_POST['search']) ?>"</strong></h2>

	<ul class="nav nav-tabs"> <!-- Affichage du menu dynamique -->
		<li class="active"><a data-toggle="tab" href="#event">Événements</a></li>
		<li><a data-toggle="tab" href="#user">Utilisateurs</a></li>
		<li><a data-toggle="tab" href="#participants">Personnes</a></li>
		<li><a data-toggle="tab" href="#itypes">Types d'identification</a></li>
	</ul>

	<div class="tab-content">
		<!-- Affichage des événements trouvés -->
		<div id="event" class="tab-pane fade in active">
<?php
if($stmt1->rowCount() == 0) // Si aucun événement n'est trouvé
{
	echo "<br><p>Aucun résultat trouvé</p>";
}
else // Affichage des résutats trouvés
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
	} // fin de while event
?>
					</tbody>
				</table>
			</div> <!-- table-responsive -->
<?php
} // fin de condition event
?>
		</div> <!-- id event -->
		<!-- Affichage des utilisateurs trouvés -->
		<div id="user" class="tab-pane fade">
<?php
if($stmt2->rowCount() == 0) // S'il n'y a aucun utilisateur trouvé
{
	echo "<br><p>Aucun résultat trouvé</p>";
}
else // Affichage des résultats sinon
{
?>
			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>Login</th>
							<th>Rôle</th>
							<th>Modifier le mot de passe</th>
						</tr>
					</thead>
					<tbody>
<?php
	while(($user = $stmt2->fetch()))
	{
?>
						<tr>
							<td><?= htmlspecialchars($user['uid']) ?></td>
							<td><?= htmlspecialchars($user['login']) ?></td>
							<td><?php if($user['role'] == "admin"){ ?>Administrateur<?php } else{ ?>Utilisateur<?php } ?></td>
							<td><a href="../users/password_change.php?uid=<?= $user['uid'] ?>">Modifier le mot de passe</a></td>
						</tr>
<?php
	} // fin de while user
?>
					</tbody>
				</table>
			</div> <!-- table-responsive -->
<?php
} // fin de condition user
?>
		</div> <!-- id user -->

		<!-- Affichage des personnes trouvées -->
		<div id="participants" class="tab-pane fade">
<?php
if($stmt3->rowCount() == 0) // S'il n'y a aucune personne trouvée
{
	echo "<br><p>Aucun résultat trouvé</p>";
}
else // Affichage des résultats sinon
{
?>	
			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>Nom et prénom</th>
							<th>Modifier</th>
							<th>Supprimer</th>
						</tr>
					</thead>
					<tbody>
<?php
	$i = 0;
	while(($row = $stmt3->fetch()))
	{
?>
						<tr>
							<td><?= $row['pid'] ?></td>
							<td><a href="../participants/identifications/identifications_list.php?pid=<?= $row['pid'] ?>"><?= htmlspecialchars($row['nom']) . " " . htmlspecialchars($row['prenom']) ?></a></td>
							<td><a href="../participants/participants_change.php?pid=<?= $row['pid'] ?>" role="button" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span></a></td>
							<td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?= $i ?>">
									<span class="glyphicon glyphicon-trash"></span>
								</button>
							</td> <!-- Modal de suppression -->
						</tr>
<?php
		require("../participants/participants_delete_form.php"); // Formulaire de suppression
		$i++;
	} // fin de while personne
?>
					</tbody>
				</table>
			</div> <!-- table-responsive -->
<?php
} // fin de condition personne
?>
		</div> <!-- id participants -->

		<div id="itypes" class="tab-pane fade">
<?php
if($stmt4->rowCount() == 0) // S'il n'y a aucun type d'identification trouvé
{
	echo "<br><p>Aucun résultat trouvé</p>";
}
else // Affichage des résultats sinon
{
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
	$i = 0;
	while(($row = $stmt4->fetch()))
	{
?>
						<tr>
							<td><?= htmlspecialchars($row['tid']) ?></td>
							<td><?= htmlspecialchars($row['nom']) ?></td>
							<td><a href="../itypes/itypes_change.php?tid=<?= $row['tid'] ?>" role="button" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span></a></td>
							<td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?= $i ?>">
									<span class="glyphicon glyphicon-trash"></span>
								</button>
							</td> <!-- Modal de suppression -->
						</tr>
<?php
		require("../itypes/itypes_delete_form.php"); // Formulaire de suppression
		$i++;
	} // fin de while itype
?>
					</tbody>
				</table>
			</div> <!-- table-responsive -->
<?php
} // fin de condition itype
?>
		</div> <!-- id itypes -->
	</div> <!-- table-content -->
</div> <!-- container -->
