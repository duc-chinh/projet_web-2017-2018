<?php
require("../../../auth/EtreAuthentifie.php");

$title = "Suppression du justificatif";
require("../../../includes/header.php");

if($idm->getRole() != "admin")
{
	$_SESSION['error'] = "Vous n'avez pas accès à cette page.";
	redirect($pathFor['root']);
	exit();
}

if(empty($_GET['pid']) || empty($_GET['tid']))
{
	redirect("participants_list.php");
	exit();
}

foreach(['pid','tid'] as $id) $data[$id] = $_GET[$id]; // Traitement des données reçues par le lien

// Vérification de l'existence du justificatif
$SQL = "SELECT * FROM identifications WHERE pid=:pid AND tid=:tid";
$stmt = $db->prepare($SQL);
$res = $stmt->execute($data);

if($res && !$stmt->fetch())
{
	$_SESSION['error'] = "Le justificatif n'existe pas.";
	redirect("participants_list.php");
	exit();
}

if(empty($_POST['delete']))
{
	$_SESSION['error'] = "Erreur lors de la tentative de suppression de l'événement.";
	redirect("identifications_list.php?pid=" . $data['pid']);
	exit();
}
else // Si le bouton "Supprimer" a été cliqué
{
	try // Suppression du justificatif
	{
		$SQL = "DELETE FROM identifications WHERE pid=:pid AND tid=:tid";
		$stmt = $db->prepare($SQL);
		$res = $stmt->execute($data);
		if($stmt->rowCount() == 0) $_SESSION['error'] = "Erreur lors de la suppression du justificatif.";
		else $_SESSION['success'] = "Suppression du justificatif réussie !";
		
		redirect("identifications_list.php?pid=" . $data['pid']);
	}
	catch(PDOException $e)
	{
		http_response_code(500);
		echo "<div class=\"container\"><p>Erreur de serveur: " . $e->getMessage() . "</p></div>";
	}
}
require("../../../includes/footer.php");
