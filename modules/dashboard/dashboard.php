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

$sort = "";

if(!empty($_GET['sort'])) // Si une option de tri a été sélectionnée
{
	if($_GET['sort'] == "date" || $_GET['sort'] == "nom" || $_GET['sort'] == "intitule")
	{
		if($_GET['sort'] != "date") $sort = $_GET['sort'] . ", ";
		$sort .= "date DESC";
	}
	else // Tri par défaut si l'option saisie est autre que "date", "nom" ou "intitule"
	{
		redirect("dashboard.php");
		exit();
	}
}
else // Tri par défaut si non
{
	$sort = "intitule, date DESC";
}

// Récupération des participations
$SQL = "SELECT participations.pid, participations.eid, intitule, personnes.nom, prenom, date, categories.nom AS categorie, type, login
			FROM participations INNER JOIN evenements ON participations.eid = evenements.eid
								INNER JOIN personnes ON participations.pid = personnes.pid
								INNER JOIN users ON users.uid = participations.uid
								INNER JOIN categories ON categories.cid = evenements.cid
			ORDER BY " . $sort;
$stmt = $db->prepare($SQL);
$row = $stmt->execute();

require("dashboard_form.php");

require("../../includes/footer.php");
