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
	<h2>Connexion</h2><br>
	<form class="form-horizontal" method="post">
		<div class="form-group">
			<div class="col-sm-2">
				<label class="control-label" for="imputLogin">Nom d'utilisateur</label>
			</div> <!-- col-sm-2 -->
			<div class="col-xs-4">
				<input type="text" name="login" size="20" class="form-control" id="inputLogin" required placeholder="Nom d'utilisateur" required value="<?= $data['login'] ?? "" ?>">
			</div> <!-- col-xs-4 -->
		</div> <!-- form-group -->

		<div class="form-group">
			<div class="col-sm-2">
				<label class="control-label" for="inputMDP">Mot de passe</label>
			</div> <!-- col-sm-2 -->
			<div class="col-xs-4">
				<input type="password" class="form-control" name="password" size="20" required id="inputMDP" placeholder="Mot de passe">
			</div> <!-- col-xs-4 -->
		</div> <!-- form-group -->

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<span class="pull-left">Pas encore membre ? <a href="<?= $pathFor['adduser'] ?>">S'enregistrer</a></span>
			</div> <!-- col-sm-offset-2 col-sm-10 -->
		</div> <!-- form-group -->
		
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default">Connexion</button>
			</div> <!-- col-sm-offset-2 col-sm-10 -->
		</div> <!-- form-group -->
	</form>
</div> <!-- container -->
