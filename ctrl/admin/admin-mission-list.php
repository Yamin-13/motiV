<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/mission.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/association.php';

$dbConnection = getConnection($dbConfig);
$titrePage = "Missions en cours";

// Vérifie que l'utilisateur est un admin
$idRole = $_SESSION['user']['idRole'];
if ($idRole != 10) {
    header('Location: /ctrl/login/login-display.php');
    exit();
}

// Récupère toutes les missions en cours
$missions = getAllOngoingMissions($dbConnection);

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/admin/admin-mission-list.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';