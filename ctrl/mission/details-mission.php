<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/mission.php';

$dbConnection = getConnection($dbConfig);
$titrePage = "Détails de la mission | MotiV – La plateforme qui valorise l'effort";

// Vérifie que l'ID de la mission est fourni dans l'URL
if (!isset($_GET['id'])) {
    $_SESSION['error'] = 'Mission non spécifiée.';
    header('Location: /ctrl/mission/mission-list.php');
    exit();
}
$missionId = $_GET['id'];

// Récupère les détails de la mission
$mission = getMissionById($missionId, $dbConnection);

// Vérifie si la mission existe
if (!$mission) {
    $_SESSION['error'] = 'Mission introuvable.';
    header('Location: /ctrl/mission/mission-list.php');
    exit();
}

// Calcul de la duré de la mission en heure
$durationInHours = (strtotime($mission['end_date_mission']) - strtotime($mission['start_date_mission'])) / 3600;

// Formatage des date pour un affichage lisible
$startDateTime = new DateTime($mission['start_date_mission']);
$endDateTime = new DateTime($mission['end_date_mission']);

$startDateFormatted = $startDateTime->format('d/m/Y');
$startTimeFormatted = $startDateTime->format('H:i');

$endDateFormatted = $endDateTime->format('d/m/Y');
$endTimeFormatted = $endDateTime->format('H:i');

// Récupère les jeunes inscrits à la mission
$registeredUsers = getRegisteredUsersByMission($missionId, $dbConnection);

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/mission/details-mission.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';