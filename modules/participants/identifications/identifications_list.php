<?php
require("../../../auth/EtreAuthentifie.php");

$title = "Liste des justificatifs";
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

// Vérification de l'existence de la personne
$SQL = "SELECT * FROM personnes WHERE pid=?";
$stmt = $db->prepare($SQL);
$res = $stmt->execute([$_GET['pid']]);
$name = $stmt->fetch();

if($res && !$name)
{
	$_SESSION['error'] = "La personne n'existe pas.";
	redirect("../participants_list.php");
	exit();
}

// Récupération des justificatifs
$SQL = "SELECT personnes.nom, prenom, itypes.nom AS type, identifications.tid, valeur FROM personnes INNER JOIN identifications ON personnes.pid = identifications.pid INNER JOIN itypes ON itypes.tid = identifications.tid WHERE identifications.pid = " . $_GET['pid'];
$stmt = $db->prepare($SQL);
$row = $stmt->execute();

require("identifications_list_form.php");
require("../../../includes/footer.php");
