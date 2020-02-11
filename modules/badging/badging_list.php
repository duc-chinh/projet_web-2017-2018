<?php
require("../../auth/EtreAuthentifie.php");

$title = "Liste des inscriptions";
require("../../includes/header.php");

if($idm->getRole() != "user")
{
	$_SESSION['error'] = "Vous n'avez pas accès à cette page.";
	redirect($pathFor['root']);
	exit();
}

if(empty($_GET['eid']))
{
	redirect("../events/events_list.php");
	exit();
}

$error = "";

// Vérification de l'existence de l'événement
$SQL = "SELECT * FROM evenements WHERE eid = ?";
$stmt = $db->prepare($SQL);
$res = $stmt->execute([$_GET['eid']]);
$row = $stmt->fetch();

if($res && !$row)
{
	$_SESSION['error'] = "L'événement n'existe pas.";
	redirect($pathFor['events_list']);
	exit();
}

// Récupération des justificatifs des personnes inscrites à l'événement
$SQL = "SELECT DISTINCT personnes.nom, prenom, itypes.nom AS id, valeur FROM participations INNER JOIN personnes ON participations.pid = personnes.pid INNER JOIN identifications ON identifications.pid = personnes.pid INNER JOIN itypes ON itypes.tid = identifications.tid  WHERE participations.eid = ? ORDER BY personnes.nom";
$stmt = $db->prepare($SQL);
$res = $stmt->execute([$_GET['eid']]);

require("badging_list_form.php");

require("../../includes/footer.php");
