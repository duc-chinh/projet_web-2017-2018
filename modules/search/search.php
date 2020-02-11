<?php
require("../../auth/EtreAuthentifie.php");
$title = "Résultats de recherche";

require("../../includes/header.php");

if(empty($_POST['search']))
{
	$_SESSION['error'] = "Nope";
	redirect($pathFor['root']);
	exit();
}

$search = "%" . $_POST['search'] . "%";

// Récupération des événements correspondant à la recherche
$SQL = "SELECT eid, intitule, description, dateDebut, dateFin, type, categories.nom FROM evenements INNER JOIN categories ON categories.cid = evenements.cid WHERE intitule LIKE ? OR description LIKE ?";
$stmt1 = $db->prepare($SQL);
$event = $stmt1->execute(array($search,$search));

if($idm->getRole() == "admin")
{	
	// Récupération des utilisateurs correspondant à la recherche
	$SQL = "SELECT * FROM users WHERE login LIKE ?";
	$stmt2 = $db->prepare($SQL);
	$user = $stmt2->execute([$search]);

	// Récupération des personnes correspondant à la recherche
	$SQL = "SELECT * FROM personnes WHERE nom LIKE ? OR prenom LIKE ?";
	$stmt3 = $db->prepare($SQL);
	$row = $stmt3->execute(array($search,$search));

	// Récupération des types d'identification correspondant à la recherche
	$SQL = "SELECT * FROM itypes WHERE nom LIKE ?";
	$stmt4 = $db->prepare($SQL);
	$row = $stmt4->execute([$search]);
}
if($idm->getRole() == "admin") require("search_form_admin.php");
else require("search_form_user.php");

require("../../includes/footer.php");
