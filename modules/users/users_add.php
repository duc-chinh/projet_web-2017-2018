<?php
require("../../auth/EtreAuthentifie.php");

$title = "Ajout d'un utilisateur";
require("../../includes/header.php");

if($idm->getRole() != "admin")
{
	$_SESSION['error'] = "Vous n'avez pas accès à cette page.";
	redirect($pathFor['root']);
	exit();
}

if(empty($_POST['login'])) // Affichage du formulaire s'il est vide
{
	require("users_add_form.php");
	require("../../includes/footer.php");
	exit();
}

$error = "";

foreach(['login','mdp','mdp2','role'] as $name) // Traitement des données saisies dans le formulaire
{
	if(empty($_POST[$name])) $error .= "Le champ '$name' ne doit pas être vide. ";
	else $data[$name] = $_POST[$name];
}

// Vérification de l'existence du login
if(empty($error))
{
	if($auth->existIdentity($data['login']))
	{
		$error .= "Le nom d'utilisateur est déjà utilisé. ";
	}
}

if($data['mdp'] != $data['mdp2']) $error .= "Les mots de passes ne correspondent pas. ";

if(!empty($error)) // Affichage des erreurs
{
	require("users_add_form.php");
	require("../../includes/footer.php");
	exit();
}

foreach(['login','mdp','role'] as $name) $clearData[$name] = $data[$name];

$passwordFunction =
	function($s)
	{
		return password_hash($s, PASSWORD_DEFAULT);
	};

$clearData['mdp'] = $passwordFunction($data['mdp']); // Hashage du mot de passe

try // Ajout de l'utilisateur
{
	$SQL = "INSERT INTO users(login,mdp,role) VALUES (:login,:mdp,:role)";
	$stmt = $db->prepare($SQL);
	$res = $stmt->execute($clearData);
	if($stmt->rowCount() == 0)
	{
		$error = "Erreur lors de l'ajout de l'utilisateur. ";
		require("users_add_form.php");
		require("../../includes/footer.php");
		exit();
	}
	else
	{
		$_SESSION['success'] = "Ajout de <strong>" . htmlspecialchars($clearData['login']) . "</strong> réussi !";
		redirect("users_list.php");
	}
}
catch(PDOException $e)
{
	http_response_code(500);
	echo "<div class=\"container\"><p>Erreur de serveur: " . $e->getMessage() . "</p></div>";
}
require("../../includes/footer.php");
