<?php
require("../../auth/EtreAuthentifie.php");

$title = "Modification de la personne";
require("../../includes/header.php");

if($idm->getRole() != "admin")
{
	$_SESSION['error'] = "Vous n'avez pas accès à cette page.";
	redirect($pathFor['root']);
	exit();
}

if(empty($_GET['pid']))
{
	redirect("participants_list.php");
	exit();
}

$error = "";

// Vérification de l'existence de la personne
$SQL = "SELECT * FROM personnes WHERE pid=?";
$stmt = $db->prepare($SQL);
$res = $stmt->execute([$_GET['pid']]);
$row = $stmt->fetch();

if($res && !$row)
{
	$_SESSION['error'] = "La personne n'existe pas.";
	redirect("participants_list.php");
	exit();
}

if(empty($_POST['nom']) && empty($_POST['prenom'])) // Affichage du formulaire s'il est vide
{
	require("participants_change_form.php");
	require("../../includes/footer.php");
	exit();
}

foreach(['nom','prenom'] as $name) // Traitement des données saisies dans le formulaire
{
	if(empty($_POST[$name])) $error .= "Le champ '$name' ne doit pas être vide. ";
	else $data[$name] = $_POST[$name];
}

if(!empty($error)) // Affichage des erreurs
{
	require("participants_change_form.php");
	require("../../includes/footer.php");
	exit();
}

$data['pid'] = $_GET['pid'];

try // Modification de la personne
{
	$SQL = "UPDATE personnes SET nom=:nom, prenom=:prenom WHERE pid=:pid";
	$stmt = $db->prepare($SQL);
	$res = $stmt->execute($data);
	if($stmt->rowCount() == 0)
	{
		$error = "Erreur lors de la modification de la personne. ";
		require("participants_change_form.php");
		require("../../includes/footer.php");
		exit();
	}
	else
	{
		$_SESSION['success'] = "Modification de <strong>" . htmlspecialchars($data['nom']) . " " .
		htmlspecialchars($data['prenom']) . "</strong> réussie ! ";
		redirect("participants_list.php");
	}
}
catch(PDOException $e)
{
	http_response_code(500);
	echo "<div class=\"container\"><p>Erreur de serveur: " . $e->getMessage() . "</p></div>";
}
require("../../includes/footer.php");
