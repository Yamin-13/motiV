<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/mission.php';

$dbConnection = getConnection($dbConfig);

// Vérifie que l'utilisateur est un jeune (idRole 60)
if ($_SESSION['user']['idRole'] != 60) {
    $_SESSION['error'] = 'Vous n\'êtes pas autorisé à annuler cette mission.';
    header('Location: /ctrl/mission/mission-list-public.php');
    exit();
}

// Vérifie que l'ID de la mission est fourni
if (!isset($_GET['id'])) {
    $_SESSION['error'] = 'Mission non spécifiée.';
    header('Location: /ctrl/mission/mission-list-public.php');
    exit();
}

$missionId = $_GET['id'];
$userId = $_SESSION['user']['id'];

// Annule l'inscription de l'utilisateur à la mission
if (unregisterFromMission($missionId, $userId, $dbConnection)) {
    $_SESSION['success'] = 'Vous avez annulé votre inscription à la mission.';
} else {
    $_SESSION['error'] = 'Impossible d\'annuler votre inscription.';
}

header('Location: /ctrl/mission/mission-list-public.php');
exit();