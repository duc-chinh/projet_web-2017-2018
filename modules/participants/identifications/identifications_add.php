<?php
require("../../../auth/EtreAuthentifie.php");

$title = "Ajout d'un justificatif";
require("../../../includes/header.php");

if($idm->getRole() != "admin")
{
	$_SESSION['error'] = "Vous n'avez pas accès à cette page.";
	redirect($pathFor['root']);
	exit();
}

if(empty($_GET['pid']))
{
	redirect("../participants_list.php");
	exit();
}

$error = "";

// Vérification de l'existence de la personne
$SQL = "SELECT * FROM personnes WHERE pid=?";
$stmt = $db->prepare($SQL);
$res = $stmt->execute([$_GET['pid']]);

if($res && !$stmt->fetch())
{
	$_SESSION['error'] = "La personne n'existe pas.";
	redirect("../participants_list.php");
	exit();
}

// Récupération des types d'idenfication pour le formulaire
$SQL = "SELECT * FROM itypes";
$stmt = $db->prepare($SQL);
$typ = $stmt->execute();

if(empty($_POST['valeur'])) // Affichage du formulaire s'il est vide
{
	require("identifications_add_form.php");
	require("../../../includes/footer.php");
	exit();
}

foreach(['tid','valeur'] as $type) // Traitement des données saisies dans le formulaire
{
	if(empty($_POST[$type])) $error .= "Le champ '$type' ne doit pas être vide. ";
	else $data[$type] = $_POST[$type];
}

$data['pid'] = $_GET['pid'];

if(empty($error)) // Vérification de l'existence du justificatif
{
	$SQL = "SELECT * FROM identifications WHERE pid=:pid AND tid=:tid";
	$stmt = $db->prepare($SQL);
	$res = $stmt->execute(array('pid' => $data['pid'], 'tid' => $data['tid']));
	if($res && $stmt->fetch()) $error .= "La personne possède déjà ce justificatif. ";
}

if(!empty($error)) // Affichage des erreurs
{
	require("identifications_add_form.php");
	require("../../../includes/footer.php");
	exit();
}

try // Ajout du justificatif
{
	$SQL = "INSERT INTO identifications VALUES (:pid,:tid,:valeur)";
	$stmt = $db->prepare($SQL);
	$res = $stmt->execute($data);
	if($stmt->rowCount() == 0)
	{
		$error = "Erreur lors de l'ajout du justificatif.";
		require("identifications_add_form.php");
		require("../../../includes/footer.php");
		exit();
	}
	else
	{
		$_SESSION['success'] = "Ajout du justificatif réussi !";
		redirect("identifications_list.php?pid=" . $data['pid']);
	}
}
catch(PDOException $e)
{
	http_response_code(500);
	echo "<div class=\"container\"><p>Erreur de serveur: " . $e->getMessage() . "</p></div>";
}

require("../../../includes/footer.php");
