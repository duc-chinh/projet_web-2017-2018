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

if(empty($_GET['date']))
{
	redirect("dashboard.php");
	exit();
}

$format = "Y-m-d";
$checkdate = DateTime::createFromFormat($format,$_GET['date']);
if($checkdate == false || $_GET['date'] != $checkdate->format($format))
{
	$_SESSION['error'] = "Le format de la date ne correspond pas.";
	redirect("dashboard.php");
	exit();
}

$sort = "";

if(!empty($_GET['sort'])) // Si une option de tri a été sélectionnée
{
	if($_GET['sort'] == "date" || $_GET['sort'] == "nom" || $_GET['sort'] == "intitule")
	{
		if($_GET['sort'] != "date") $sort = $_GET['sort'] . ", ";
		$sort .= "date ASC";
	}
	else // Tri par défaut si l'option saisie est autre que "date", "nom" ou "intitule"
	{
		redirect("dashboard_date.php");
		exit();
	}
}
else // Tri par défaut si non
{
	$sort = "date ASC";
}

// Affichage des participations de la date
$SQL = "SELECT participations.pid, participations.eid, intitule, personnes.nom, prenom, date, categories.nom AS categorie, type, login
			FROM participations INNER JOIN evenements ON participations.eid = evenements.eid 
								INNER JOIN personnes ON participations.pid = personnes.pid
								INNER JOIN users ON users.uid = participations.uid
								INNER JOIN categories ON categories.cid = evenements.cid
			WHERE DATE(participations.date) = ? ORDER BY " . $sort;
$stmt = $db->prepare($SQL);
$row = $stmt->execute([$_GET['date']]);

require("dashboard_date_form.php");

require("../../includes/footer.php");
