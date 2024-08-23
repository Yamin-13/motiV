<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/mission.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/association.php';

$dbConnection = getConnection($dbConfig);

// Vérifie que l'utilisateur est un admin ou un membre de l'association
$idRole = $_SESSION['user']['idRole'];
if ($idRole != 50 && $idRole != 55) {
    header('Location: /ctrl/mission/mission-list-public.php');
    exit();
}

// Vérifie que l'ID de la mission est bien fourni
$idMission = $_GET['id'] ?? null;
if (!$idMission) {
    $_SESSION['error'] = "ID de mission manquant.";
    header('Location: /ctrl/mission/mission-list.php');
    exit();
}

// Récupère l'ID de l'association de la mission et vérifie que l'utilisateur appartient à cette association
$idUserAssociation = getAssociationIdByUserId($_SESSION['user']['id'], $dbConnection);
$idMissionAssociation = getAssociationIdByMissionId($idMission, $dbConnection);

if ($idUserAssociation != $idMissionAssociation) {
    $_SESSION['error'] = "Vous ne pouvez pas supprimer cette mission.";
    header('Location: /ctrl/mission/mission-list.php');
    exit();
}

// Supprime la mission
if (deleteMission($idMission, $dbConnection)) {
    $_SESSION['success'] = "Mission supprimée avec succès.";
} else {
    $_SESSION['error'] = "Erreur lors de la suppression de la mission.";
}

header('Location: /ctrl/mission/mission-list.php');
exit();