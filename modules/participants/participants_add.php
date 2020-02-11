<?php
require("../../auth/EtreAuthentifie.php");

$title = "Ajout d'une personne";
require("../../includes/header.php");

if($idm->getRole() != "admin")
{
	$_SESSION['error'] = "Vous n'avez pas accès à cette page.";
	redirect($pathFor['root']);
	exit();
}

if(empty($_POST['nom']) && empty($_POST['prenom'])) // Affichage du formulaire s'il est vide
{
	require("participants_add_form.php");
	require("../../includes/footer.php");
	exit();
}

$error = "";

foreach(['nom','prenom'] as $name) // Traitement des données saisies dans le formulaire
{
	if(empty($_POST[$name])) $error .= "Le champ '$name' ne doit pas être vide. ";
	else $data[$name] = $_POST[$name];
}

// Vérification de l'existence de la personne
$SQL = "SELECT pid FROM personnes WHERE nom=:nom AND prenom=:prenom";
$stmt = $db->prepare($SQL);
$res = $stmt->execute($data);

if($res && $stmt->fetch()) $error .= "La personne est déjà inscrite. ";

if(!empty($error)) // Affichage des erreurs
{
	require("participants_add_form.php");
	require("../../includes/footer.php");
	exit();
}

try // Ajout d'une personne
{
	$SQL = "INSERT INTO personnes(nom,prenom) VALUES (:nom,:prenom)";
	$stmt = $db->prepare($SQL);
	$res = $stmt->execute($data);
	if($stmt->rowCount() == 0)
	{
		$error = "Erreur lors de l'ajout de la personne. ";
		require("participants_add_form.php");
		require("../../includes/footer.php");
		exit();
	}
	else
	{
		$_SESSION['success'] = "Ajout de <strong>" . htmlspecialchars($data['nom']) . " " .
		htmlspecialchars($data['prenom']) . "</strong> réussi ! ";
		redirect("participants_list.php");
	}
}
catch(PDOException $e)
{
	http_response_code(500);
	echo "<div class=\"container\"><p>Erreur de serveur: " . $e->getMessage() . "</p></div>";
}
require("../../includes/footer.php");
