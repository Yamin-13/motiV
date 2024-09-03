<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/mission.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/point.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/message.php';

$dbConnection = getConnection($dbConfig);

// Vérifie que l'utilisateur est un admin ou un membre de l'association
$idRole = $_SESSION['user']['idRole'];
if ($idRole != 50 && $idRole != 55) {
    header('Location: /ctrl/login/login-display.php');
    exit();
}

$idMission = $_POST['idMission'];

// Récupère les utilisateurs inscrits à cette mission
$registeredUsers = getRegisteredUsersByMission($idMission, $dbConnection);
$mission = getMissionById($idMission, $dbConnection);

// Calcule les points attribués en fonction de la durée de la mission
$totalPoints = calculatePointsForMission($mission['start_date_mission'], $mission['end_date_mission']) * $mission['point_award'];

// Attribue les points et envoie une notification à chaque utilisateur
foreach ($registeredUsers as $user) {
    awardPoints($user['idUser'], $totalPoints, 'Mission accomplie', $dbConnection);

    // Envoi d'une notification
    $subject = "Félicitations ! Vous avez reçu des points pour une mission accomplie.";
    $body = "Vous avez reçu {$totalPoints} points pour avoir complété la mission \"{$mission['title']}\".";
    sendMessage($user['idUser'], $subject, $body, $dbConnection);

    // Marque la mission comme complété pour chaque utilisateur
    $query = "UPDATE mission_registration SET status = 'completed' WHERE idMission = :idMission AND idUser = :idUser";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $idMission);
    $statement->bindParam(':idUser', $user['idUser']);
    $statement->execute();
}

$_SESSION['success'] = "Mission complétée et points attribués.";
header('Location: /ctrl/association/mission-list.php');
exit();