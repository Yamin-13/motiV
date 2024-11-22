<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';

$dbConnection = getConnection($dbConfig);
$titrePage = "Détails de l'étudiant | MotiV – La plateforme qui valorise l'effort";

// Vérification du role de l'utilisateur
$idRole = $_SESSION['user']['idRole'];
if (!in_array($idRole, [20, 25, 27])) {
    // Si l'utilisateur n'est pas un membre d'un établissement scolaire
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