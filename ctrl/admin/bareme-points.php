<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';

$dbConnection = getConnection($dbConfig);


$idRole = $_SESSION['user']['idRole'];
if ($idRole != 10) {
    header('Location: /ctrl/login/login-display.php');
    exit();
}

// Si le formulaire est soumis ca met à jour les paramètres
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pointsPerHour = intval($_POST['points_per_hour']);
    $ineValidationPoints = intval($_POST['ine_validation_points']);

    // Mets à jour du barème dans la table site_configuration
    $query = "UPDATE site_configuration SET key_value = :points_per_hour WHERE key_name = 'points_per_hour'";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':points_per_hour', $pointsPerHour, PDO::PARAM_INT);
    $statement->execute();

    $query = "UPDATE site_configuration SET key_value = :ine_validation_points WHERE key_name = 'ine_validation_points'";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':ine_validation_points', $ineValidationPoints, PDO::PARAM_INT);
    $statement->execute();
    
    $_SESSION['success'] = "Les paramètres ont été mis à jour avec succès.";
    header('Location: /ctrl/admin/bareme-points.php');
    exit();
}

// Récupére les valeurs actuelle des paramètres
$query = "SELECT key_name, key_value FROM site_configuration WHERE key_name IN ('points_per_hour', 'ine_validation_points')";
$statement = $dbConnection->prepare($query);
$statement->execute();
$configurations = $statement->fetchAll(PDO::FETCH_KEY_PAIR);

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/admin/bareme-points.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';