<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/mission.php';

$dbConnection = getConnection($dbConfig);
$titrePage = "Historique des Missions Accomplies";

// Vérification que l'utilisateur est connecté et a le rôle approprié
if (!isset($_SESSION['user']) || $_SESSION['user']['idRole'] != 60) {
    header('Location: /ctrl/login/login-display.php');
    exit();
}

// Récupére l'ID de l'utilisateur
$idUser = $_SESSION['user']['id'];

// Récupére les missions accomplies pour cet utilisateur
$missions = getCompletedMissionsByUser($idUser, $dbConnection);

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/young/history-missions.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';