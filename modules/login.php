<?php
require("../auth/EtreInvite.php");

$title = "Connexion";
require("../includes/header.php");

if(empty($_POST['login']) && empty($_POST['password'])) // Affichage du formulaire s'il est vide
{
	require("login_form.php");
	require("../includes/footer.php");
	exit();
}

$error = "";

foreach(['login','password'] as $name) // Traitement des données saisies dans le formulaire
{
	if(empty($_POST[$name])) $error .= "Erreur lors de l'authentification. ";
}

if(empty($error))
{
	$data['login'] = $_POST['login'];
	$data['password'] = $_POST['password'];
	// Vérification de l'existence du login
	if(!$auth->existIdentity($data['login'])) $error .= "L'utilisateur n'existe pas. ";
}

if(empty($error))
{
	$role = $auth->authenticate($data['login'], $data['password']); // Connexion
	if(!$role) $error .= "Erreur lors de l'authentification. ";
}

if(!empty($error))
{
	require("login_form.php");
	require("../includes/footer.php");
	exit();
}

if(isset($_SESSION[SKEY])) // Session
{
	$uri = $_SESSION[SKEY];
	unset($_SESSION[SKEY]);
	redirect($uri);
	exit();
}

$_SESSION['success'] = "Connexion réussie. Bienvenue sur iBento <strong>" . $idm->getIdentity() . "</strong> ! ";
redirect($pathFor['root']);
