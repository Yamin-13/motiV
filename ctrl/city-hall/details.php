<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/city-hall.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';

$dbConnection = getConnection($dbConfig);
$titrePage = "Détails de la mairie | MotiV – La plateforme qui valorise l'effort";


// Vérification du rôle de l'utilisateur
$idRole = $_SESSION['user']['idRole'];
if ($idRole != 10) {
    // Si l'utilisateur n'est pas un admin, redirige vers la page de connexion
    header('Location: /ctrl/login/login-display.php');
    exit();
}

if (!isset($_GET['id'])) {
    die('ID de la mairie manquant.');
}

$id = $_GET['id'];
$cityHall = getCityHallById($id, $dbConnection);

if (!$cityHall) {
    die('Mairie non trouvée.');
}

$admin = getUserById($cityHall['idUser'], $dbConnection);

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/city-hall/details.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';