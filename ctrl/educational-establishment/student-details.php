<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';

$dbConnection = getConnection($dbConfig);
$titrePage = "motiV";

// Vérification du rôle de l'utilisateur
$idRole = $_SESSION['user']['idRole'];
if ($idRole != [20, 25]) {
    // Si l'utilisateur n'est pas un admin, redirige vers la page de connexion
    header('Location: /ctrl/login/login-display.php');
    exit();
}

if (!isset($_GET['id'])) {
    die('ID utilisateur manquant.');
}

$user = getUserById($_GET['id'], $dbConnection);

if (!$user) {
    die('Utilisateur non trouvé.');
}

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/educational-establishment/student-details.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';