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

if(empty($_GET['eid']))
{
	redirect("dashboard.php");
	exit();
}

// Vérification de l'existence de l'événement
$SQL = "SELECT * FROM evenements WHERE eid = ?";
$stmt = $db->prepare($SQL);
$res = $stmt->execute([$_GET['eid']]);
$event = $stmt->fetch();
if($res && !$event)
{
	$_SESSION['error'] = "L'événement n'existe pas.";
	redirect("dashboard.php");
	exit();
}

$sort = "";

if(!empty($_GET['sort'])) // Si une option de tri a été sélectionnée
{
	if($_GET['sort'] == "date" || $_GET['sort'] == "nom")
	{
		if($_GET['sort'] != "date") $sort = $_GET['sort'] . ", ";
		$sort .= "date DESC";
	}
	else // Tri par défaut si l'option saisie est autre que "date" ou "nom"
	{
		redirect("dashboard.php");
		exit();
	}
}
else // Tri par défaut si non
{
	$sort = "nom, date DESC";
}

// Récupération des participations de l'événement
$SQL = "SELECT nom, prenom, date, login FROM personnes INNER JOIN participations ON participations.pid = personnes.pid
													   INNER JOIN users ON users.uid = participations.uid
			WHERE participations.eid = ? ORDER BY " . $sort;
$st = $db->prepare($SQL);
$row = $st->execute([$_GET['eid']]);

// Récupération des personnes non inscrites à l'événement
$SQL = "SELECT nom, prenom FROM personnes WHERE pid IN
				(SELECT pid FROM inscriptions WHERE eid = :eid AND pid NOT IN
						(SELECT pid FROM participations WHERE eid = :eid)
				)";
$stmt = $db->prepare($SQL);
$res = $stmt->execute(array('eid' => $_GET['eid']));

require("dashboard_event_form.php");

require("../../includes/footer.php");
