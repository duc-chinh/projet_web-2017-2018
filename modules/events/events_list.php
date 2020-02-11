<?php
require("../../auth/EtreAuthentifie.php");

$title = "Liste des événements";
require("../../includes/header.php");

if(!empty($_GET['cid'])) // S'il n'y a pas de catégorie sélectionnée
{
	// Vérification de l'existence de la catégorie
	$cid = $_GET['cid'];
	$SQL = "SELECT * FROM categories WHERE cid = ?";
	$stmt = $db->prepare($SQL);
	$res = $stmt->execute([$cid]);
	if($res && $stmt->fetch()) // Affichage des événements de la catégorie
	{
		$SQL = "SELECT eid, intitule, description, dateDebut, dateFin, type, categories.nom FROM evenements INNER JOIN categories ON evenements.cid = categories.cid WHERE evenements.cid = ?";
		$stmt = $db->prepare($SQL);
		$row = $stmt->execute([$cid]);
	}
	else
	{
		$_SESSION['error'] = "La catégorie d'événements n'existe pas.";
		redirect($pathFor['root']);
		exit();
	}
}
else // Affichage de tous les événements
{
	$SQL = "SELECT eid, intitule, description, dateDebut, dateFin, type, categories.nom FROM evenements INNER JOIN categories ON evenements.cid = categories.cid";
	$stmt = $db->prepare($SQL);
	$row = $stmt->execute();
}

if($idm->getRole() == "admin") require("events_list_admin.php");
else if($idm->getRole() == "user") require("events_list_user.php");

require("../../includes/footer.php");
