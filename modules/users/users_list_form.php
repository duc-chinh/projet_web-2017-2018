<div class="container">
	<h2>Liste des utilisateurs</h2>
<?php
if($stmt->rowCount() == 0) // S'il n'y a aucun utilisateur
{
	echo "<p>Il n'y a aucun utilisateur !</p>";
}
else // Affichage du tableau si oui
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
	while(($row = $stmt->fetch()))
	{
?>
				<tr>
					<td><?= htmlspecialchars($row['uid']) ?></td>
					<td><?= htmlspecialchars($row['login']) ?></td>
					<td><?php if($row['role'] == "admin"){ ?>Administrateur<?php } else{ ?>Utilisateur<?php } ?></td>
					<td><a href="password_change.php?uid=<?= $row['uid'] ?>">Modifier le mot de passe</a></td>
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
	<span><a href="users_add.php" role="button" class="btn btn-success">Ajouter un utilisateur</a></span>
</div> <!-- container -->