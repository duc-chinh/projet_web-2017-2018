<?php
require("../../auth/EtreAuthentifie.php");

$title = "Nouvelle participation";
require("../../includes/header.php");

if($idm->getRole() != "user")
{
	$_SESSION['error'] = "Vous n'avez pas accès à cette page.";
	redirect($pathFor['root']);
	exit();
}

if(empty($_GET['eid']))
{
	redirect("../events/events_list.php");
	exit();
}

$error = "";

// Vérification de l'existence de l'événement
$SQL = "SELECT * FROM evenements WHERE eid = ?";
$stmt = $db->prepare($SQL);
$res = $stmt->execute([$_GET['eid']]);
$event = $stmt->fetch();

if($res && !$event)
{
	$_SESSION['error'] = "L'événement n'existe pas.";
	redirect("../events/events_list.php");
	exit();
}

if($event['type'] == "ferme") // Si l'événement est fermé
{
	if(empty($_POST['pid']) && empty($_POST['tid']) && empty($_POST['valeur'])) // Affichage du formulaire s'il est vide
	{	
		require("badging_add_form.php");
		require("../../includes/footer.php");
		exit();
	}

	foreach(['pid','tid','valeur'] as $badge) // Traitement des données saisies dans le formulaire
	{
		if(empty($_POST[$badge])) $error .= "Le champ '$badge' ne doit pas être vide. ";
		else $data[$badge] = $_POST[$badge];
	}
}
else // Si l'événement est ouvert
{
	// Affichage du formulaire s'il est vide
	if(empty($_POST['nom']) && empty($_POST['prenom']) && empty($_POST['tid']) && empty($_POST['valeur']))
	{	
		require("badging_add_form.php");
		require("../../includes/footer.php");
		exit();
	}

	foreach(['nom','prenom','tid','valeur'] as $badge) // Traitement des données saisies dans le formulaire
	{
		if(empty($_POST[$badge])) $error .= "Le champ '$badge' ne doit pas être vide. ";
		else $data[$badge] = $_POST[$badge];
	}
}

if(!empty($error)) // Affichage des erreurs
{
	require("badging_add_form.php");
	require("../../includes/footer.php");
	exit();
}

if($event['type'] == "ferme") // Si l'événement est fermé
{
	// Vérification du justificatif correspondant à la personne
	$SQL = "SELECT * FROM identifications WHERE pid=:pid AND tid=:tid AND valeur=:valeur";
	$stmt = $db->prepare($SQL);
	$row = $stmt->execute($data);
	if($row && !$stmt->fetch())
	{
		$error .= "Le justificatif fourni ne correspond pas à celui présenté lors de l'inscription. ";
		if($row['tid'] == 4) $error .= "Veuillez respecter l'ordre: Nom Prénom. ";
	}
}
else // Si l'événement est ouvert
{
	// Vérification de l'existence de la personne
	$dataName['nom'] = $data['nom'];
	$dataName['prenom'] = $data['prenom'];

	$SQL = "SELECT * FROM personnes WHERE nom=:nom AND prenom=:prenom";
	$stmt = $db->prepare($SQL);
	$res = $stmt->execute($dataName);
	$row = $stmt->fetch();
	if($res && $row) // Récupération de l'ID si elle existe
	{
		$data['pid'] = $row['pid'];
	}
	else // Ajout de la personne si non
	{
		$SQL = "INSERT INTO personnes (nom,prenom) VALUES (:nom,:prenom)";
		$stmt = $db->prepare($SQL);
		$res = $stmt->execute($dataName);
		$data['pid'] = $db->lastInsertId();
	}

	// Vérification du justificatif selectionné
	$dataId['pid'] = $data['pid'];
	$dataId['tid'] = $data['tid'];
	$SQL = "SELECT valeur FROM identifications WHERE pid=:pid AND tid=:tid";
	$stmt = $db->prepare($SQL);
	$row = $stmt->execute($dataId);
	$value = $stmt->fetch();
	if($row && $value) // Comparaison des 2 valeurs s'il existe
	{
		if($value['valeur'] != $data['valeur'])
		{
			$error .= "Le justificatif fourni ne correspond pas à celui présenté lors des anciennes participations. ";
			if($data['tid'] == 4) $error .= "Veuillez respecter l'ordre: Nom Prénom. ";
		}
	}
	else // Ajout du nouveau justificatif si non
	{
		$add_id = true;
		if($data['tid'] == 4) // Vérification du nom et prénom s'il est choisi
		{	
			$name1 = $data['nom'] . " " . $data['prenom'];
			if($name1 != $data['valeur'])
			{	
				$error .= "La valeur du justificatif ne correspond pas au nom et prénom saisi
				(veuillez respecter l'ordre: Nom Prénom). ";
				$add_id = false;
			}
		}

		if($add_id == true)
		{
			$dataId['valeur'] = $data['valeur'];
			$SQL = "INSERT INTO identifications (pid,tid,valeur) VALUES (:pid,:tid,:valeur)";
			$stmt = $db->prepare($SQL);
			$res = $stmt->execute($dataId);
		}
	}
}

if(!empty($error)) // Affichage des erreurs
{
	require("badging_add_form.php");
	require("../../includes/footer.php");
	exit();
}

// Ajout de la participation
$clearData['pid'] = $data['pid'];
$clearData['eid'] = $_GET['eid'];
$clearData['uid'] = $idm->getUid();
$clearData['date'] = date("Y-m-d H:i:s");

/*
 * Condition interdisant la participation si la date de fin a été atteinte
 * ou la date de début n'a pas encore été atteinte
 * Désactivée pour effectuer les tests avec la base de données originale
 *
if($clearData['date'] > $event['dateFin'] || $clearData['date'] < $event['dateDebut'])
{
	$_SESSION['error'] = "L'événement est terminé, impossible d'y participer.";
	redirect("../events/events_list.php");
	exit();
}
 */

try
{
	$SQL = "INSERT INTO participations (eid,pid,date,uid) VALUES (:eid,:pid,:date,:uid)";
	$stmt = $db->prepare($SQL);
	$res = $stmt->execute($clearData);
	if($stmt->rowCount() == 0)
	{
		$error = "Erreur lors de la soumission de la participation. ";
		require("badging_add_form.php");
		require("../../includes/footer.php");
		exit();
	}
	else
	{
		$_SESSION['success'] = "Soumission de la participation réussie ! ";
		redirect("../events/events_list.php");
	}
}
catch(PDOException $e)
{
	http_response_code(500);
	echo "<div class=\"container\"><p>Erreur de serveur: " . $e->getMessage() . "</p></div>";
}

require("../../includes/footer.php");
