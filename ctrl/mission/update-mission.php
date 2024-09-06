<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/mission.php';

// Connexion à la base de données
$dbConnection = getConnection($dbConfig);
$titrePage = "motiV";

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    $_SESSION['error'] = "Veuillez vous connecter.";
    header('Location: /ctrl/login/login-display.php');
    exit();
}

// Récupère l'ID de la mission
$idMission = $_GET['id'] ?? null;

if (!$idMission) {
    $_SESSION['error'] = "Mission non trouvée.";
    header('Location: /ctrl/mission/mission-list.php');
    exit();
}

// Récupère les détails de la mission
$mission = getMissionById($idMission, $dbConnection);

// Traitement de la soumission du formulaire de mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $start_date = $_POST['start_date'];
    $start_time = $_POST['start_time'];
    $end_date = $_POST['end_date'];
    $end_time = $_POST['end_time'];
    $number_of_places = $_POST['number_of_places'];

    // Gestion de l'image
    $image_filename = $mission['image_filename']; // Utilise l'image actuelle si aucune nouvelle image n'est fournie
    if (!empty($_FILES['image']['name'])) {
        $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
        $image_filename = basename($_FILES['image']['name']);
        $uploadPath = $uploadDirectory . $image_filename;

        // Déplace le fichier téléchargé vers le répertoire cible
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
            $_SESSION['error'] = 'Erreur lors de l\'upload de l\'image.';
            header('Location: /ctrl/mission/update-mission.php?id=' . $idMission);
            exit();
        }
    }

    // Combine la date et l'heure pour le format DATETIME
    $start_date_time = DateTime::createFromFormat('Y-m-d H:i', "$start_date $start_time")->format('Y-m-d H:i:s');
    $end_date_time = DateTime::createFromFormat('Y-m-d H:i', "$end_date $end_time")->format('Y-m-d H:i:s');

    // Met à jour la mission dans la base de données
    $updated = updateMission($idMission, $title, $description, $start_date, $start_time, $end_date, $end_time, $number_of_places, $image_filename, $dbConnection);

    if ($updated) {
        $_SESSION['success'] = "Mission mise à jour avec succès.";
        header('Location: /ctrl/mission/mission-list.php?id=' . $idMission);
        exit();
    } else {
        $_SESSION['error'] = "Erreur lors de la mise à jour de la mission.";
    }
}

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/mission/update-mission.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';