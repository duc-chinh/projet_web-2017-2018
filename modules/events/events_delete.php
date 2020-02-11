<?php
require("../../auth/EtreAuthentifie.php");

$title = "Suppression de l'événement";
require("../../includes/header.php");

if($idm->getRole() != "admin")
{
	$_SESSION['error'] = "Vous n'avez pas accès à cette page.";
	redirect($pathFor['root']);
	exit();
}

if(empty($_GET['eid']))
{
	redirect("events_list.php");
	exit();
}

// Vérification de l'existence de l'événement
$SQL = "SELECT * FROM evenements WHERE eid = ?";
$stmt = $db->prepare($SQL);
$res = $stmt->execute([$_GET['eid']]);
$row = $stmt->fetch();

if($res && !$row)
{
	$_SESSION['error'] = "L'événement n'existe pas.";
	redirect("events_list.php");
	exit();
}

if(empty($_POST['delete']))
{
	$_SESSION['error'] = "Erreur lors de la tentative de suppression de l'événement.";
	redirect("events_list.php");
	exit();
}
else // Si le bouton "Supprimer" a été cliqué
{
	$data['eid'] = $_GET['eid'];
	try // Suppression de l'événement
	{
		$SQL = "DELETE FROM evenements WHERE eid=?";
		$stmt = $db->prepare($SQL);
		$res = $stmt->execute([$data['eid']]);
		if($stmt->rowCount() == 0) $_SESSION['error'] = "Erreur lors de la suppression de l'événement.";
		else $_SESSION['success'] = "Suppression de l'événement réussie !";

		redirect("events_list.php");
	}
	catch(PDOException $e)
	{
		http_response_code(500);
		echo "<div class=\"container\"><p>Erreur de serveur: " . $e->getMessage() . "</p></div>";
	}
}

require("../../includes/footer.php");
