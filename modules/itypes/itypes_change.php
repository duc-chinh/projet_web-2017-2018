<?php
require("../../auth/EtreAuthentifie.php");

$title = "Modification du type d'identification";
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

$error = "";

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

if(empty($_POST['nom'])) // Affichage du formulaire s'il est vide
{
	require("itypes_change_form.php");
	require("../../includes/footer.php");
	exit();
}

// Traitement de la donnée saisie dans le formulaire
if(empty($_POST['nom'])) $error .= "Le champ 'nom' ne doit pas être vide. ";
else $data['nom'] = $_POST['nom'];

if(!empty($error)) // Affichage des erreurs
{
	require("itypes_change_form.php");
	require("../../includes/footer.php");
	exit();
}

$data['tid'] = $_GET['tid'];

try // Modification du type d'identification
{
	$SQL = "UPDATE itypes SET nom=:nom WHERE tid=:tid";
	$stmt = $db->prepare($SQL);
	$res = $stmt->execute($data);
	if($stmt->rowCount() == 0)
	{
		$error = "Erreur lors de la modification du type d'identification. ";
		require("itypes_change_form.php");
		require("../../includes/footer.php");
		exit();
	}
	else
	{
		$_SESSION['success'] = "Modification de <strong>" . htmlspecialchars($data['nom']) . "</strong> réussie ! ";
		redirect("itypes_list.php");
	}
}
catch(PDOException $e)
{
	http_response_code(500);
	echo "<div class=\"container\"><p>Erreur de serveur: " . $e->getMessage() . "</p></div>";
}
require("../../includes/footer.php");
