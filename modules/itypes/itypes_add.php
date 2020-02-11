<?php
require("../../auth/EtreAuthentifie.php");

$title = "Ajout d'un type d'identification";
require("../../includes/header.php");

if($idm->getRole() != "admin")
{
	$_SESSION['error'] = "Vous n'avez pas accès à cette page.";
	redirect($pathFor['root']);
	exit();
}

if(empty($_POST['nom'])) // Affichage du formulaire s'il est vide
{
	require("itypes_add_form.php");
	require("../../includes/footer.php");
	exit();
}

$error = "";

// Traitement de la donnée saisie dans le formulaire
if(empty($_POST['nom']))  $error .= "Le champ 'nom' ne doit pas être vide. ";
else $data['nom'] = $_POST['nom'];

if(empty($error)) // Vérification de l'existence du type d'identification
{
	$SQL = "SELECT tid FROM itypes WHERE nom=?";
	$stmt = $db->prepare($SQL);
	$res = $stmt->execute([$data['nom']]);

	if($res && $stmt->fetch())
	{
		$error .= "Le type d'identification existe déjà. ";
	}
}

if(!empty($error)) // Affichage des erreurs
{
	require("itypes_add_form.php");
	require("../../includes/footer.php");
	exit();
}

try // Ajout du nouveau type d'identification
{
	$SQL = "INSERT INTO itypes(nom) VALUES (?)";
	$stmt = $db->prepare($SQL);
	$res = $stmt->execute([$data['nom']]);
	if($stmt->rowCount() == 0)
	{
		$error = "Erreur lors de l'ajout du type d'identification. ";
		require("itypes_add_form.php");
		require("../../includes/footer.php");
		exit();
	}
	else
	{
		$_SESSION['success'] = "Ajout de <strong>" . htmlspecialchars($data['nom']) . "</strong> réussi ! ";
		redirect("itypes_list.php");
	}
}
catch(PDOException $e)
{
	http_response_code(500);
	echo "<div class=\"container\"><p>Erreur de serveur: " . $e->getMessage() . "</p></div>";
}
require("../../includes/footer.php");
