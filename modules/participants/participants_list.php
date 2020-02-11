<?php
require("../../auth/EtreAuthentifie.php");

$title = "Liste des participants";
require("../../includes/header.php");

if($idm->getRole() != "admin")
{
	redirect($pathFor['root']);
	exit();
}

$SQL = "SELECT * FROM personnes";
$stmt = $db->prepare($SQL);
$row = $stmt->execute();

require("participants_list_form.php");
require("../../includes/footer.php");
