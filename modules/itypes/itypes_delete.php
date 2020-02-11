<?php
require("../../auth/EtreAuthentifie.php");

$title = "Suppression du type d'identification";
require("../../includes/header.php");

if($idm->getRole() != "admin")
{
	$_SESSION['error'] = "Vous n'avez pas accès à cette page.";
	redirect($pathFor['root']);
	exit();
}

if(empty($_GET['tid']))
{
	redirect("itypes_list.php");
	exit();
}

// Vérification de l'existence du type d'identification
$SQL = "SELECT nom FROM itypes WHERE tid=?";
$stmt = $db->prepare($SQL);
$res = $stmt->execute([$_GET['tid']]);
$row = $stmt->fetch();

if($res && !$row)
{
	$_SESSION['error'] = "Le type d'identification n'existe pas.";
	redirect("itypes_list.php");
	exit();
}

if(empty($_POST['delete']))
{
	$_SESSION['error'] = "Erreur lors de la tentative de suppression du type d'identification.";
	redirect("itypes_list.php");
	exit();
}
else // Si le bouton "Supprimer" a été cliqué
{
	$data['tid'] = $_GET['tid'];
	try // Suppression du type d'identification
	{
		$SQL = "DELETE FROM itypes WHERE tid=?";
		$stmt = $db->prepare($SQL);
		$res = $stmt->execute([$data['tid']]);
		if($stmt->rowCount() == 0) $_SESSION['error'] = "Erreur lors de la suppression du type d'identification.";
		else $_SESSION['success'] = "Suppression du type d'identification réussie !";
		
		redirect("itypes_list.php");
	}
	catch(PDOException $e)
	{
		http_response_code(500);
		echo "<div class=\"container\"><p>Erreur de serveur: " . $e->getMessage() . "</p></div>";
	}
}
require("../../includes/footer.php");
