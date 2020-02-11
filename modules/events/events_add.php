<?php
require("../../auth/EtreAuthentifie.php");

$title = "Création d'un nouvel événement";
require("../../includes/header.php");

if($idm->getRole() != "admin")
{
	$_SESSION['error'] = "Vous n'avez pas accès à cette page.";
	redirect($pathFor['root']);
	exit();
}

// Affichage du formulaire s'il est vide
if(empty($_POST['intitule']) && empty($_POST['description']) && empty($_POST['dateDebut']) && empty($_POST['dateFin']))
{
	require("events_add_form.php");
	require("../../includes/footer.php");
	exit();
}

$error = "";

// Traitement des données saisies dans le formulaire
foreach(['intitule','description','dateDebut','dateFin','type','cid'] as $event)
{
	if(empty($_POST[$event])) $error .= "Le champ '$event' ne doit pas être vide. ";
	else $data[$event] = $_POST[$event];
}

// Vérification de l'existence d'un événement portant le même nom
$SQL = "SELECT * FROM evenements WHERE intitule = ?";
$stmt = $db->prepare($SQL);
$res = $stmt->execute([$_POST['intitule']]);

if($res && $stmt->fetch())
{
	$error .= "Un événement porte déjà ce nom. ";
	require("events_add_form.php");
	require("../../includes/footer.php");
	exit();
}

foreach(['dateDebut','dateFin'] as $date) // Vérification du format des dates saisies
{
	$format = "Y-m-d H:i:s";
	$checkdate = DateTime::createFromFormat($format,$data[$date]);
	if($checkdate == false || $data[$date] != $checkdate->format($format))
	{
		$error .= "Le format de '$date' ne correspond pas. ";
		$data[$date] = false;
	}
	else
	{
		$data[$date] = $checkdate->format($format);
	}
}

if($data['dateDebut'] != false && $data['dateFin'] != false)
{
	if($data['dateDebut'] > $data['dateFin'])
		$error .= "La date de début ne doit pas être supérieure à la date de fin. ";
}

if(!empty($error)) // Affichage des erreurs
{
	require("events_add_form.php");
	require("../../includes/footer.php");
	exit();
}

try // Ajout du nouvel événement
{
	$SQL = "INSERT INTO evenements(intitule,description,dateDebut,dateFin,type,cid) VALUES (:intitule,:description,:dateDebut,:dateFin,:type,:cid)";
	$stmt = $db->prepare($SQL);
	$res = $stmt->execute($data);
	if($stmt->rowCount() == 0)
	{
		$error = "Erreur lors de l'ajout de l'événement. ";
		require("events_add_form.php");
		require("../../includes/footer.php");
		exit();
	}
	else
	{
		$_SESSION['success'] = "Ajout de <strong>" . htmlspecialchars($data['intitule']) . "</strong> réussi !";
		redirect("events_list.php");
	}
}
catch(PDOException $e)
{
	http_response_code(500);
	echo "<div class=\"container\"><p>Erreur de serveur: " . $e->getMessage() . "</p></div>";
}
require("../../includes/footer.php");
