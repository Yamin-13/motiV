<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/mission.php';

$dbConnection = getConnection($dbConfig);

// Vérifie que l'utilisateur est un jeune (idRole 60)
if ($_SESSION['user']['idRole'] != 60) {
    $_SESSION['error'] = 'Vous n\'êtes pas autorisé à accepter cette mission.';
    header('Location: /ctrl/mission/mission-list.php');
    exit();
}

// Vérifie que l'ID de la mission est fourni avec POST
if (!isset($_POST['idMission'])) {
    $_SESSION['error'] = 'Mission non spécifiée.';
    header('Location: /ctrl/mission/mission-list-public.php');
    exit();
}

$missionId = $_POST['idMission'];
$userId = $_SESSION['user']['id'];

// Inscrit l'utilisateur à la mission
if (registerForMission($missionId, $userId, $dbConnection)) {
    $_SESSION['success'] = 'Vous avez accepté la mission.';
} else {
    $_SESSION['error'] = 'Impossible d\'accepter la mission. Il n\'y a peut-être plus de places disponibles.';
}

header('Location: /ctrl/mission/mission-list-public.php');
exit();