<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/mission.php';

$dbConnection = getConnection($dbConfig);
$titrePage = "motiV";

// Récupère toutes les mission disponibles
$missions = getAllMissions($dbConnection);

// Formate les date heure et calcul la durée pour chaque mission
foreach ($missions as $key => $mission) {
    $missions[$key]['start_date_formatted'] = date('d/m/Y', strtotime($mission['start_date_mission']));
    $missions[$key]['start_time_formatted'] = date('H:i', strtotime($mission['start_date_mission']));
    $missions[$key]['end_date_formatted'] = date('d/m/Y', strtotime($mission['end_date_mission']));
    $missions[$key]['end_time_formatted'] = date('H:i', strtotime($mission['end_date_mission']));
    $missions[$key]['duration_in_hours'] = (strtotime($mission['end_date_mission']) - strtotime($mission['start_date_mission'])) / 3600;
}

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/mission/mission-list-public.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';
