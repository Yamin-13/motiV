<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/mission.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/point.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/message.php';

$dbConnection = getConnection($dbConfig);
$titrePage = "Validation de Mission | MotiV – La plateforme qui valorise l'effort";

// Vérifie que l'utilisateur est connecté et qu'il a le role correct
if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['idRole'], [50, 55])) {
    header('Location: /ctrl/login/login-display.php');
    exit();
}

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

// Récupère les jeunes inscrits à la mission
$registeredUsers = getRegisteredUsersByMission($missionId, $dbConnection);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($registeredUsers as $user) {
        if (!isset($user['idUser'])) {
            continue; // Si l'idUser n'existe pas passe à l'utilisateur suivant
        }

        $userId = $user['idUser'];

        // Vérifie si l'utilisateur a été marqué présent ou absent
        $status = $_POST['status'][$userId] ?? ($user['marked_absent'] == 1 ? 'absent' : 'present'); 

        if ($status === 'present') {
            // Marque le jeune comme présent et attribue les points
            completeMissionForUser($missionId, $userId, $mission['point_award'], $dbConnection);
        } else {
            // Marque le jeune comme absent
            cancelMissionForUser($missionId, $userId, $dbConnection);
        }
    }

    // Met à jour la mission comme accomplie
    markMissionAsAccomplished($missionId, $dbConnection);

    $_SESSION['success'] = 'Les présences ont été validées avec succès.';
    header('Location: /ctrl/mission/mission-list.php');
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/mission/validate-mission.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';