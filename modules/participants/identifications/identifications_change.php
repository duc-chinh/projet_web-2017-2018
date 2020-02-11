<?php
require("../../../auth/EtreAuthentifie.php");

$title = "Modification du justificatif";
require("../../../includes/header.php");

if($idm->getRole() != "admin")
{
	$_SESSION['error'] = "Vous n'avez pas accès à cette page.";
	redirect($pathFor['root']);
	exit();
}

if(empty($_GET['pid']) || empty($_GET['tid']))
{
	redirect("identifications_list.php");
	exit();
}

foreach(['pid','tid'] as $id) $data[$id] = $_GET[$id]; // Traitement des données reçues par le lien

$error = "";

// Vérification de l'existence du justificatif
$SQL = "SELECT * FROM identifications WHERE pid=:pid AND tid=:tid";
$stmt = $db->prepare($SQL);
$res = $stmt->execute($data);

if($res && !$stmt->fetch())
{
	$_SESSION['error'] = "Le justificatif n'existe pas.";
	redirect("../participants_list.php");
	exit();
}


// Récupération des données pour le formulaire
$SQL = "SELECT identifications.tid, personnes.nom, prenom, itypes.nom AS type, valeur FROM personnes INNER JOIN identifications ON personnes.pid = identifications.pid INNER JOIN itypes ON itypes.tid = identifications.tid WHERE identifications.pid = :pid AND identifications.tid = :tid";
$stmt = $db->prepare($SQL);
$res = $stmt->execute($data);
$row = $stmt->fetch();
if($res && !$row)
{
	$_SESSION['error'] = "Le justificatif n'existe pas.";
	redirect("identifications_list.php?pid=" . $data['pid']);
	exit();
}

if(empty($_POST['valeur'])) // Affichage du formulaire s'il est vide
{
	require("identifications_change_form.php");
	require("../../../includes/footer.php");
	exit();
}

// Traitement des données saisies dans le formulaire
if(empty($_POST['valeur'])) $error .= "Le champ 'Valeur' ne doit pas être vide. ";
else $data['valeur'] = $_POST['valeur'];

if(!empty($error)) // Affichage des erreurs
{
	require("identifications_change_form.php");
	require("../../../includes/footer.php");
	exit();
}

try // Modification du justificatif
{
	$SQL = "UPDATE identifications SET valeur=:valeur WHERE pid=:pid AND tid=:tid";
	$stmt = $db->prepare($SQL);
	$res = $stmt->execute($data);
	if($stmt->rowCount() == 0)
	{
		$error = "Erreur lors de la modification du justificatif.";
		require("identifications_change_form.php");
		require("../../../includes/footer.php");
		exit();
	}
	else
	{
		$_SESSION['success'] = "Modification du justificatif réussie !";
		redirect("identifications_list.php?pid=" . $data['pid']);
	}
}
catch(PDOException $e)
{
	http_response_code(500);
	echo "<div class=\"container\"><p>Erreur de serveur: " . $e->getMessage() . "</p></div>";
}
require("../../../includes/footer.php");
