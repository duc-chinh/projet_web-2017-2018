<?php
require("../../auth/EtreAuthentifie.php");

$title = "Modification de l'événement";
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

$error = "";

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

// Récupération des catégories pour le formulaire
$SQL = "SELECT * FROM categories";
$stmt = $db->prepare($SQL);
$cat = $stmt->execute();

// Affichage du formulaire s'il est vide
if(empty($_POST['intitule']) && empty($_POST['description']) && empty($_POST['dateDebut']) && empty($_POST['dateFin']))
{
	require("events_change_form.php");
	require("../../includes/footer.php");
	exit();
}

// Traitement des données saisies dans le formulaire
foreach(['intitule','description','dateDebut','dateFin','type','cid'] as $event)
{
	if(empty($_POST[$event]))
	{
		$error .= "Le champ '$event' ne doit pas être vide. ";
	}
	else
	{
		$data[$event] = $_POST[$event];
	}
}

foreach(['dateDebut','dateFin'] as $date) // Vérification du format des dates saisies
{
	$format = "Y-m-d H:i:s";
	$checkdate = DateTime::createFromFormat($format,$data[$date]);
	if($checkdate == false || $data[$date] != $checkdate->format($format))
	{
		$error .= "Le format de '$date' ne correspond pas. ";
	}
	else
	{
		$data[$date] = $checkdate->format($format);
	}
}

if(empty($error))
{
	if($data['dateDebut'] > $data['dateFin'])
		$error .= "La date de début ne doit pas être supérieure à la date de fin. ";
}

if(!empty($error)) // Affichage des erreurs
{
	require("events_change_form.php");
	require("../../includes/footer.php");
	exit();
}

$data['eid'] = $_GET['eid'];

try // Modification de l'événement
{
	$SQL = "UPDATE evenements SET intitule=:intitule, description=:description, dateDebut=:dateDebut, dateFin=:dateFin, type=:type, cid=:cid WHERE eid=:eid";
	$stmt = $db->prepare($SQL);
	$res = $stmt->execute($data);
	if($stmt->rowCount() == 0)
	{
		$error = "Erreur lors de la modification de l'événement. ";
		require("events_change_form.php");
		require("../../includes/footer.php");
		exit();
	}
	else
	{
		$_SESSION['success'] = "Modification de <strong>" . htmlspecialchars($data['intitule']) . "</strong> réussie ! ";
		redirect("events_list.php");
	}
}
catch(PDOException $e)
{
	http_response_code(500);
	echo "<div class=\"container\"><p>Erreur de serveur: " . $e->getMessage() . "</p></div>";
}
require("../../includes/footer.php");
