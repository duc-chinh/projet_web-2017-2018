<?php
require("../../auth/EtreAuthentifie.php");

$title = "Modification du mot de passe";
require("../../includes/header.php");

if($idm->getRole() != "admin")
{
	$_SESSION['error'] = "Vous n'avez pas accès à cette page.";
	redirect($pathFor['root']);
	exit();
}

if(empty($_GET['uid']))
{
	redirect("users_list.php");
	exit();
}

$error = "";

// Vérification de l'existence de l'utilisateur
$SQL = "SELECT * FROM users WHERE uid = ?";
$stmt = $db->prepare($SQL);
$res = $stmt->execute([$_GET['uid']]);
$row = $stmt->fetch();

if($res && !$row)
{
	$_SESSION['error'] = "L'utilisateur n'existe pas.";
	redirect("users_list.php");
	exit();
}

if(empty($_POST['mdp'])) // Affichage du formulaire s'il est vide
{
	require("password_change_form.php");
	require("../../includes/footer.php");
	exit();
}

foreach(['mdp','mdp2'] as $password) // Traitement des données saisies dans le formulaire
{
	if(empty($_POST[$password])) $error .= "Le champ '$password' ne doit pas être vide. ";
	else $data[$password] = $_POST[$password];
}

if($data['mdp'] != $data['mdp2']) $error .= "Les mots de passes ne correspondent pas. ";

if(!empty($error)) // Affichage des erreurs
{
	require("password_change_form.php");
	require("../../includes/footer.php");
	exit();
}

$clearData['mdp'] = $data['mdp'];
$clearData['uid'] = $_GET['uid'];

$passwordFunction =
	function($s)
	{
		return password_hash($s, PASSWORD_DEFAULT);
	};

$clearData['mdp'] = $passwordFunction($data['mdp']); // Hashage du mot de passe

try // Modification du mot de passe
{
	$SQL = "UPDATE users SET mdp=:mdp WHERE uid=:uid";
	$stmt = $db->prepare($SQL);
	$res = $stmt->execute($clearData);
	if($stmt->rowCount() == 0)
	{
		$error = "Erreur lors de la modification du mot de passe. ";
		require("password_change_form.php");
		require("../../includes/footer.php");
		exit();
	}
	else
	{
		$_SESSION['success'] = "Modification du mot de passe réussie !";
		redirect("users_list.php");
	}
}
catch(PDOException $e)
{
	http_response_code(500);
	echo "<div class=\"container\"><p>Erreur de serveur: " . $e->getMessage() . "</p></div>";
}
require("../../includes/footer.php");
