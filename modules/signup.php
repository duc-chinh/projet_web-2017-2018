<?php
require("../auth/EtreInvite.php");

$title = "Inscription";
require("../includes/header.php");

if(empty($_POST['login'])) // Affichage du formulaire s'il est vide
{
	require("signup_form.php");
	require("../includes/footer.php");
	exit();
}

$error = "";

foreach(['login','mdp','mdp2'] as $name) // Traitement des données saisies dans le formulaire
{
	if(empty($_POST[$name])) $error .= "Le champ '$name' ne doit pas être vide. ";
	else $data[$name] = $_POST[$name];
}

if(empty($error))
{
	// Vérification de l'existence du login
	if($auth->existIdentity($data['login'])) $error .= "Le nom d'utilisateur est déjà utilisé. ";
}

if($data['mdp'] != $data['mdp2']) // Comparaison des 2 mots de passe
{
	$error .= "Les mots de passes ne correspondent pas. ";
}

if(!empty($error)) // Affichage des erreurs
{
	require("signup_form.php");
	require("../includes/footer.php");
	exit();
}

foreach(['login','mdp'] as $name)
{
	$clearData[$name] = $data[$name];
}

$passwordFunction =
	function($s)
	{
		return password_hash($s, PASSWORD_DEFAULT);
	};

$clearData['mdp'] = $passwordFunction($data['mdp']); // Hashage du mot de passe

try // Inscription de l'utilisateur
{
	$SQL = "INSERT INTO users(login,mdp) VALUES (:login,:mdp)";
	$stmt = $db->prepare($SQL);
	$res = $stmt->execute($clearData);
	if($stmt->rowCount() == 0)
	{
		$error .= "Erreur lors de l'inscription. ";
		require("signup_form.php");
		require("../includes/footer");
		exit();
	}
	else
	{	
		$id = $db->lastInsertId();
		$auth->authenticate($clearData['login'], $data['mdp']);
		$_SESSION['success'] = "Inscription réussie. Bienvenue sur iBento <strong>" . $idm->getIdentity() . "</strong> ! ";
		redirect($pathFor['root']);
	}
}
catch(PDOException $e)
{
	http_response_code(500);
	echo "<div class=\"container\"><p>Erreur de serveur: " . $e->getMessage() . "</p></div>";
}
require("../includes/footer.php");
