<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/mission.php';

$dbConnection = getConnection($dbConfig);
$titrePage = "Historique des Missions";

// Vérifie que l'utilisateur est connecté et qu'il a le rôle correct
if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['idRole'], [50, 55])) {
    header('Location: /ctrl/login/login-display.php');
    exit();
}

$idAssociation = $_SESSION['user']['idAssociation'];
$missions = getAccomplishedMissionsByAssociation($idAssociation, $dbConnection);

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/mission/history-mission.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';