<?php
require("../../auth/EtreAuthentifie.php");

$title = "Liste des types d'identification";
require("../../includes/header.php");

if($idm->getRole() != "admin")
{
	$_SESSION['error'] = "Vous n'avez pas accès à cette page.";
	redirect($pathFor['root']);
	exit();
}

// Récupération des types d'identification
$SQL = "SELECT * FROM itypes";
$stmt = $db->prepare($SQL);
$row = $stmt->execute();

require("itypes_list_form.php");

require("../../includes/footer.php");
