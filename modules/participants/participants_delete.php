<?php
require("../../auth/EtreAuthentifie.php");

$title = "Suppression de la personne";
require("../../includes/header.php");

if($idm->getRole() != "admin")
{
	$_SESSION['error'] = "Vous n'avez pas accès à cette page.";
	redirect($pathFor['root']);
	exit();
}

if(empty($_GET['pid']))
{
	redirect("participants_list.php");
	exit();
}

// Vérification de l'existence de la personne
$SQL = "SELECT * FROM personnes WHERE pid=?";
$stmt = $db->prepare($SQL);
$res = $stmt->execute([$_GET['pid']]);
$row = $stmt->fetch();

if($res && !$row)
{
	$_SESSION['error'] = "La personne n'existe pas.";
	redirect("participants_list.php");
	exit();
}

if(empty($_POST['delete']))
{
	$_SESSION['error'] = "Erreur lors de la tentative de suppression de la personne.";
	redirect("participants_list.php");
	exit();
}
else // Si le bouton "Supprimer" a été cliqué
{
	$data['pid'] = $_GET['pid'];
	try // Suppression de la personne
	{
		$SQL = "DELETE FROM personnes WHERE pid=:pid";
		$stmt = $db->prepare($SQL);
		$res = $stmt->execute(array('pid' => $data['pid']));
		if($stmt->rowCount() == 0) $_SESSION['error'] = "Erreur lors de la suppression de la personne.";
		else $_SESSION['success'] = "Suppression de la personne réussie ! ";
		
		redirect("participants_list.php");
	}
	catch(PDOException $e)
	{
		http_response_code(500);
		echo "<div class=\"container\"><p>Erreur de serveur: " . $e->getMessage() . "</p></div>";
	}
}
require("../../includes/footer.php");
