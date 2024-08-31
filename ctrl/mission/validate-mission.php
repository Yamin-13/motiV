<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/mission.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/point.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/message.php';

$dbConnection = getConnection($dbConfig);
$titrePage = "MotiV";

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
            continue; // Si l'idUser n'existe pas on passe à l'utilisateur suivant
        }

        $userId = $user['idUser'];
        $status = $_POST['status'][$userId] ?? 'absent'; // Par défaut l'utilisateur est marqué comme absent

        if ($status === 'present') {
            // Marque le jeune comme présent et complète la mission
            $query = "UPDATE mission_registration SET status = 'completed' WHERE idMission = :idMission AND idUser = :idUser";
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':idMission', $missionId);
            $statement->bindParam(':idUser', $userId);
            $statement->execute();

            // Attribue les points au jeune
            awardPoints($userId, $mission['point_award'], 'Mission accomplie', $dbConnection);

            // Envoie un message au jeune
            sendNotification($userId, 'Mission accomplie', 'Vous avez reçu ' . $mission['point_award'] . ' points pour avoir complété la mission.', $dbConnection);
        } else {
            // Marque le jeune comme absent
            $query = "UPDATE mission_registration SET status = 'canceled', marked_absent = 1 WHERE idMission = :idMission AND idUser = :idUser";
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':idMission', $missionId);
            $statement->bindParam(':idUser', $userId);
            $statement->execute();

            // Retire 50 point au jeune, sans descendre en dessous de 0
            $pointsToRemove = min(50, getUserPoints($userId, $dbConnection));
            awardPoints($userId, -$pointsToRemove, 'Absence à la mission', $dbConnection);

            // Envoie un message au jeune
            sendNotification($userId, 'Absence à la mission', 'Vous avez perdu ' . $pointsToRemove . ' points pour absence à la mission.', $dbConnection);
        }
    }

    // Une fois les présence validés on marque la mission comme accompli
    $query = "UPDATE mission SET status = 'accomplished' WHERE id = :idMission";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $missionId, PDO::PARAM_INT);
    $statement->execute();

    $_SESSION['success'] = 'Les présences ont été validées avec succès.';
    header('Location: /ctrl/mission/mission-list.php');
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/mission/validate-mission.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';