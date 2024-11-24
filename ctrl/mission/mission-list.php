<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/mission.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/association.php';

$dbConnection = getConnection($dbConfig);
$titrePage = "Liste des missions | MotiV – La plateforme qui valorise l'effort";

$idRole = $_SESSION['user']['idRole'];
if ($idRole != 50 && $idRole != 55) {
    header('Location: /ctrl/login/login-display.php');
    exit();
}

// Vérifie que l'ID est stocké dans la session
if (!isset($_SESSION['user']['idAssociation'])) {
    $_SESSION['user']['idAssociation'] = getAssociationIdByUserId($_SESSION['user']['id'], $dbConnection);
}

// Récupère les missions pour l'association
$idAssociation = $_SESSION['user']['idAssociation'];
$missions = getMissionsByAssociation($idAssociation, $dbConnection);

// Formate les date et heure pour chaque mission
foreach ($missions as $key => $mission) {
    
    $startTimestamp = strtotime($mission['start_date_mission']);
    $endTimestamp = strtotime($mission['end_date_mission']);

    $missions[$key]['start_date_formatted'] = date('d/m/Y', strtotime($mission['start_date_mission']));
    $missions[$key]['start_time_formatted'] = date('H:i', strtotime($mission['start_date_mission']));
    $missions[$key]['end_date_formatted'] = date('d/m/Y', strtotime($mission['end_date_mission']));
    $missions[$key]['end_time_formatted'] = date('H:i', strtotime($mission['end_date_mission']));
    
    // Calcul de la durée en heures
    $missions[$key]['duration_in_hours'] = ($endTimestamp - $startTimestamp) / 3600;
}

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/mission/mission-list.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';