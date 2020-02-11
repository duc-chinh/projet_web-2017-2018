<!DOCTYPE html>
<html lang="fr">

<html>

<head>
	<meta charset="utf-8">
	<title><?= $title ?? "" ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="<?= $pathFor['favicon'] ?>">
	<!-- Styles -->
	<link rel="stylesheet" href="<?= $pathFor['bootstrap'] ?>">
	<link rel="stylesheet" href="<?= $pathFor['navbar'] ?>">
	<link rel="stylesheet" href="<?= $pathFor['style'] ?>">
	<script src="<?= $pathFor['jquery'] ?>"></script>
	<script src="<?= $pathFor['js'] ?>"></script>
</head>

<body>
	<header>
		<div class="jumbotron" style="background-color: lightslategrey">
			<img src="<?= $pathFor['logo'] ?>" class="center" alt="iBento"><br>
			<p style="text-align: center; color: whitesmoke">iBento - La boîte à savoir</p>
		</div> <!-- jumbotron -->
<?php
require("menu.php");
?>
	</header>

<?php
if(isset($_SESSION['success'])) // Pop-up d'action réalisée avec succès
{
?>
		<div class="alert alert-success alert-dismissible fade in" style="margin-top: -30px; margin-bottom: 30px">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Succès !</strong> <?= $_SESSION['success'] ?? "" ?>
		</div>
<?php
	$_SESSION['success'] = null;
}
else if(isset($_SESSION['error'])) // Pop-up d'erreur rencontrée lors d'une action
{
?>
		<div class="alert alert-danger alert-dismissible fade in" style="margin-top: -30px; margin-bottom: 30px">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Attention !</strong> <?= $_SESSION['error'] ?? "" ?>
		</div>
<?php
	$_SESSION['error'] = null;
}
