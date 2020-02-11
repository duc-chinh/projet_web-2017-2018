<?php
require("../../auth/EtreAuthentifie.php");

$title = "Tableau de bord";
require("../../includes/header.php");

if($idm->getRole() != "admin")
{
	$_SESSION['error'] = "Vous n'avez pas accès à cette page.";
	redirect($pathFor['root']);
	exit();
}

if(empty($_GET['pid']))
{
	redirect("dashboard.php");
	exit();
}

// Vérification de l'existence de la personne
$SQL = "SELECT * FROM personnes WHERE pid = ?";
$stmt = $db->prepare($SQL);
$res = $stmt->execute([$_GET['pid']]);
$name = $stmt->fetch();
if($res && !$name)
{
	$_SESSION['error'] = "La personne n'existe pas.";
	redirect("dashboard.php");
	exit();
}

$sort = "";

if(!empty($_GET['sort'])) // Si une option de tri a été sélectionnée
{
	if($_GET['sort'] == "date" || $_GET['sort'] == "intitule")
	{
		if($_GET['sort'] != "date") $sort = $_GET['sort'] . ", ";
		$sort .= "date DESC";
	}
	else // Tri par défaut si l'option saisie est autre que "date" ou "intitule"
	{
		redirect("dashboard.php");
		exit();
	}
}
else // Tri par défaut si non
{
	$sort = "intitule, date DESC";
}

// Récupération des participations de la personne
$SQL = "SELECT intitule, date, type, categories.nom AS categorie, login 
			FROM participations INNER JOIN evenements ON participations.eid = evenements.eid
								INNER JOIN personnes ON participations.pid = personnes.pid
								INNER JOIN users ON users.uid = participations.uid
								INNER JOIN categories ON categories.cid = evenements.cid
			WHERE participations.pid = ? ORDER BY " . $sort;
$st = $db->prepare($SQL);
$row = $st->execute([$_GET['pid']]);

// Récupération des événements où la personne n'est pas inscrite
$SQL = "SELECT intitule, dateDebut, dateFin, type, categories.nom AS categorie
			FROM evenements INNER JOIN categories ON evenements.cid = categories.cid
			WHERE eid IN
				(SELECT eid FROM inscriptions WHERE pid = :pid AND eid NOT IN
					(SELECT eid FROM participations WHERE pid = :pid)
				)";
$stmt = $db->prepare($SQL);
$res = $stmt->execute(array('pid' => $_GET['pid']));

require("dashboard_participant_form.php");

require("../../includes/footer.php");
