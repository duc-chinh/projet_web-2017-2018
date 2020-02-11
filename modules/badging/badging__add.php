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

// Définition du nombre de formulaires à traiter
if(empty($_GET['nb']))
{
	$nb = 1;
}
else if($_GET['nb'] > 0 && $_GET['nb'] <= 5)
{
	$nb = $_GET['nb'];
}
else
{
	redirect("../events/events_list.php");
	exit();
}

for($n = 1; $n <= $nb; $n++) // Affichage des formulaires si l'un d'entre eux est vide
{
	if(empty($_POST['eid'.$n]) && empty($_POST['nom'.$n]) && empty($_POST['prenom'.$n])
			&& empty($_POST['tid'.$n]) && empty($_POST['valeur'.$n]))
	{
		require("badging__add_form.php");
		require("../../includes/footer.php");
		exit();
	}
}

for($n = 1; $n <= $nb; $n++) // Traitement des données saisies dans les formulaires
{
	$error[$n] = "";
	// Vérification du contenu du formulaire
	if(empty($_POST['eid'.$n])) $error[$n] .= "Le champ 'Evénement' ne doit pas être vide. ";
	else $data[$n]['eid'] = $_POST['eid'.$n];
	if(empty($_POST['nom'.$n])) $error[$n] .= "Le champ 'Nom' ne doit pas être vide. ";
	else $data[$n]['nom'] = $_POST['nom'.$n];
	if(empty($_POST['prenom'.$n])) $error[$n] .= "Le champ 'Prénom' ne doit pas être vide. ";
	else $data[$n]['prenom'] = $_POST['prenom'.$n];
	if(empty($_POST['tid'.$n])) $error[$n] .= "Le champ 'Type d'identification' ne doit pas être vide. ";
	else $data[$n]['tid'] = $_POST['tid'.$n];
	if(empty($_POST['valeur'.$n])) $error[$n] .= "Le champ 'Valeur' ne doit pas être vide. ";
	else $data[$n]['valeur'] = $_POST['valeur'.$n];

	// Vérification de l'existence de l'événement
	$SQL = "SELECT * FROM evenements WHERE eid = ?";
	$stmt = $db->prepare($SQL);
	$res = $stmt->execute([$data[$n]['eid']]);
	$event = $stmt->fetch();

	if($res && !$event)
	{
		$error[$n] .= "L'événement n'existe pas. ";
		$data[$n]['eid'] = "";
	}

	$dataName = null;
	$dataId = null;

	if($event['type'] == "ferme") // Si l'événement est fermé
	{
		// Vérification de l'inscription de la personne à l'événement fermé
		$dataName['eid'] = $data[$n]['eid'];
		$dataName['nom'] = $data[$n]['nom'];
		$dataName['prenom'] = $data[$n]['prenom'];

		$SQL = "SELECT pid FROM inscriptions WHERE eid=:eid AND pid = (SELECT pid FROM personnes WHERE nom=:nom AND prenom=:prenom)";
		$stmt = $db->prepare($SQL);
		$row = $stmt->execute($dataName);
		$pid = $stmt->fetch();
		if($row && !$pid)
		{
			$error[$n] .= htmlspecialchars($data[$n]['nom']) . " " . htmlspecialchars($data[$n]['prenom'])
			. " n'est pas inscrit(e) à l'événement. ";
		}
		
		if(!empty($error[$n])) continue; // Passage au prochain formulaire en cas d'erreur
		$data[$n]['pid'] = $pid['pid'];

		// Vérification du justificatif sélectionné
		$dataId['pid'] = $pid['pid'];
		$dataId['tid'] = $data[$n]['tid'];
		$dataId['valeur'] = $data[$n]['valeur'];

		$SQL = "SELECT * FROM identifications WHERE pid=:pid AND tid=:tid AND valeur=:valeur";
		$stmt = $db->prepare($SQL);
		$row = $stmt->execute($dataId);
		if($row && !$stmt->fetch())
		{
			$error[$n] .= "Le justificatif fourni ne correspond pas à celui présenté lors de l'inscription. ";
			if($dataId['tid'] == 4) $error[$n] .= "Veuillez respecter l'ordre: Nom Prénom. ";
		}
	}
	else // Si l'événement est ouvert
	{
		// Vérification de l'existence d'une personne
		$dataName['nom'] = $data[$n]['nom'];
		$dataName['prenom'] = $data[$n]['prenom'];

		$SQL = "SELECT * FROM personnes WHERE nom=:nom AND prenom=:prenom";
		$stmt = $db->prepare($SQL);
		$res = $stmt->execute($dataName);
		$row = $stmt->fetch();
		if($res && $row) // Récupération de l'ID si elle existe
		{
			$data[$n]['pid'] = $row['pid'];
		}
		else // Ajout de la nouvelle personne si non
		{
			$SQL = "INSERT INTO personnes (nom,prenom) VALUES (:nom,:prenom)";
			$stmt = $db->prepare($SQL);
			$res = $stmt->execute($dataName);
			$data[$n]['pid'] = $db->lastInsertId();
		}

		// Vérification du justificatif sélectionné
		$dataId['pid'] = $data[$n]['pid'];
		$dataId['tid'] = $data[$n]['tid'];
		$SQL = "SELECT valeur FROM identifications WHERE pid=:pid AND tid=:tid";
		$stmt = $db->prepare($SQL);
		$row = $stmt->execute($dataId);
		$value = $stmt->fetch();
		if($row && $value) // Comparaison des 2 valeurs s'il existe
		{
			if($value['valeur'] != $data[$n]['valeur'])
			{
				$error[$n] .= "Le justificatif fourni ne correspond pas à celui présenté lors des anciennes participations. ";
				if($data[$n]['tid'] == 4) $error[$n] .= "Veuillez respecter l'ordre: Nom Prénom. ";
			}
		}
		else // Ajout du nouveau justificatif si non
		{
			$add_id = true;
			if($data[$n]['tid'] == 4) // Vérification du nom et prénom s'il est choisi
			{
				$name1 = $data[$n]['nom'] . " " . $data[$n]['prenom'];
				if($name1 != $data[$n]['valeur'])
				{	
					$error[$n] .= "La valeur du justificatif ne correspond pas au nom et prénom saisi
					(veuillez respecter l'ordre: Nom Prénom). ";
					$add_id = false;
				}
			}

			if($add_id == true)
			{
				$dataId['valeur'] = $data[$n]['valeur'];
				$SQL = "INSERT INTO identifications (pid,tid,valeur) VALUES (:pid,:tid,:valeur)";
				$stmt = $db->prepare($SQL);
				$res = $stmt->execute($dataId);
			}
		}
	}

	if(!empty($error[$n])) continue; // Passage au prochain formulaire en cas d'erreur

	// Récupération des valeurs à insérer pour la participation
	$clearData[$n]['pid'] = $data[$n]['pid'];
	$clearData[$n]['eid'] = $data[$n]['eid'];
	$clearData[$n]['uid'] = $idm->getUid();
	$clearData[$n]['date'] = date("Y-m-d H:i:s");

	/*
	 * Condition interdisant la participation si la date de fin a été atteinte
	 * ou si la date de début n'a pas encore été atteinte
	 * Désactivée pour effectuer les tests avec la base de données originale
	 *
	if($clearData[$n]['date'] > $event['dateFin'] || $clearData[$n]['date'] < $event['dateDebut'])
	{
		$error[$n] = "L'événement est terminé, impossible d'y participer.";
	}

	if(!empty($error[$n])) continue; // Passage au prochain formulaire en cas d'erreur
	 */
}

for($n = 1; $n <= $nb; $n++) // Affichage des erreurs avant l'ajout des participations
{
	if(!empty($error[$n]))
	{
		require("badging__add_form.php");
		require("../../includes/footer.php");
		exit();
	}
	$error[$n] = "";
}

for($n = 1; $n <= $nb; $n++) // Ajout des participations
{
	try
	{
		$SQL = "INSERT INTO participations (eid,pid,date,uid) VALUES (:eid,:pid,:date,:uid)";
		$stmt = $db->prepare($SQL);
		$res = $stmt->execute($clearData[$n]);
		if($stmt->rowCount() == 0) $error[$n] = "Erreur lors de la soumission de la participation n°" . $n . ". ";
	}
	catch(PDOException $e)
	{
		http_response_code(500);
		echo "<div class=\"container\"><p>Erreur de serveur: " . $e->getMessage() . "</p></div>";
	}
}

for($n = 1; $n <= $nb; $n++) // Affichage des erreurs rencontrées lors de l'ajout des participations
{
	if(!empty($error[$n]))
	{
		require("badging__add_form.php");
		require("../../includes/footer.php");
		exit();
	}
}

if($nb == 1) $_SESSION['success'] = "Soumission de la participation réussie !";
else $_SESSION['success'] = "Soumission en batch des participations réussie !";

redirect("../events/events_list.php");

require("../../includes/footer.php");
