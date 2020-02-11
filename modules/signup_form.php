<?php
if(!empty($error)) // Affichage des messages d'erreur
{
?>
<div class="alert alert-danger alert-dismissible fade in" style="margin-top: -30px; margin-bottom: 30px">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Attention !</strong> <?= $error ?? "" ?>
</div>
<?php
}
?>

<div class="container">
	<h2>Inscription</h2><br/>
	<form class="form-horizontal" method="post">
		<div class="form-group">
			<div class="col-sm-2">
				<label for="inputLogin" class="control-label">Nom d'utilisateur</label>
			</div> <!-- col-sm-2 -->
			<div class="col-xs-4">
				<input type="text" name="login" class="form-control" id="inputLogin" placeholder="Nom d'utilisateur" required value="<?= $data['login'] ?? "" ?>">
			</div>
		</div> <!-- form-group -->

		<div class="form-group">
			<div class="col-sm-2">
				<label for="inputMDP" class="control-label">Mot de passe</label>
			</div> <!-- col-sm-2 -->
			<div class="col-xs-4">
				<input type="password" name="mdp" class="form-control" id="inputMDP" placeholder="Mot de passe" required value="">
			</div> <!-- col-xs-4 -->
		</div> <!-- form-group -->

		<div class="form-group">
			<div class="col-sm-2">
				<label for="inputMDP2" class="control-label" style="text-align: left; margin-top: -9px">Répéter mot de passe</label>
			</div> <!-- col-sm-2 -->
			<div class="col-xs-4">
				<input type="password" name="mdp2" class="form-control" id="inputMDP2" placeholder="Répéter le mot de passe" required value="">
			</div> <!-- col-xs-4 -->
		</div> <!-- form-group -->

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<span class="pull-left">Déjà inscrit(e) ? <a href="<?= $pathFor['login'] ?>">Se connecter</a></span>
			</div> <!-- col-sm-offset-2 col-sm-10 -->
		</div> <!-- form-group -->
		
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default">Inscription</button>
			</div> <!-- col-sm-offset-2 col-sm-10 -->
		</div> <!-- form-group -->
	</form>
</div> <!-- container -->
