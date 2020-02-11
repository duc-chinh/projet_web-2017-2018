<?php
require("../../auth/EtreAuthentifie.php");

$title = "Liste des utilisateurs";
require("../../includes/header.php");

if($idm->getRole() != "admin")
{
	$_SESSION['error'] = "Vous n'avez pas accès à cette page.";
	redirect($pathFor['root']);
	exit();
}

// Récupération des utilisateurs
$SQL = "SELECT * FROM users";
$stmt = $db->prepare($SQL);
$row = $stmt->execute();

require("users_list_form.php");
require("../../includes/footer.php");
?>