<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/mission.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/association.php';

$dbConnection = getConnection($dbConfig);
$titrePage = "motiV";

$idRole = $_SESSION['user']['idRole'];
if ($idRole != 50 && $idRole != 55) {
    header('Location: /ctrl/login/login-display.php');
    exit();
}

// Récupère l'ID de l'association de l'utilisateur
$idAssociation = getAssociationIdByUserId($_SESSION['user']['id'], $dbConnection);

if (!$idAssociation) {
    $_SESSION['error'] = "Vous n'êtes associé à aucune association.";
    header('Location: /ctrl/login/login-display.php');
    exit();
}

// Récupère la valeur du barème de points par heure depuis la base de données
$query = "SELECT key_value FROM site_configuration WHERE key_name = 'points_per_hour'";
$statement = $dbConnection->prepare($query);
$statement->execute();
$pointsPerHour = $statement->fetchColumn();

// Récupère les données du formulaire
$title = $_POST['title'];
$description = $_POST['description'];
$startDate = $_POST['start_date'];
$startTime = $_POST['start_time'];
$endDate = $_POST['end_date'];
$endTime = $_POST['end_time'];
$numberOfPlaces = $_POST['number_of_places'];
$idUser = $_SESSION['user']['id'];

// combine la date et l'heure pour créer un format compatible avec PHP
$startDateTime = DateTime::createFromFormat('Y-m-d H:i', "$startDate $startTime");
$endDateTime = DateTime::createFromFormat('Y-m-d H:i', "$endDate $endTime");

if (!$startDateTime || !$endDateTime) {
    
    $errors = DateTime::getLastErrors();
    var_dump($errors);

    $_SESSION['error'] = 'Format de date ou d\'heure incorrect.';
    header('Location: /ctrl/mission/add-mission-display.php');
    exit();
}

$startDateTimeFormatted = $startDateTime->format('Y-m-d H:i:s');
$endDateTimeFormatted = $endDateTime->format('Y-m-d H:i:s');

// Calcul des point totals basés sur la durée de la mission
$missionHours = (strtotime($endDateTimeFormatted) - strtotime($startDateTimeFormatted)) / 3600; // conversion en heures
$totalPoints = $missionHours * $pointsPerHour;

// Traitement de l'image
$imageFilename = null;
if (!empty($_FILES['image']['name'])) {
    $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
    $imageFilename = basename($_FILES['image']['name']);
    $uploadPath = $uploadDirectory . $imageFilename;

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
        $_SESSION['error'] = 'Erreur lors de l\'upload de l\'image.';
        header('Location: /ctrl/mission/add-mission-display.php');
        exit();
    }
}

// Crée la mission
if (createMission($title, $description, $totalPoints, $startDateTimeFormatted, $endDateTimeFormatted, $imageFilename, $numberOfPlaces, $idUser, $idAssociation, $dbConnection)) {
    $_SESSION['success'] = 'Mission créée avec succès.';
    header('Location: /ctrl/mission/mission-list.php');
    exit();
} else {
    $_SESSION['error'] = 'Erreur lors de la création de la mission.';
    header('Location: /ctrl/mission/add-mission-display.php');
    exit();
}