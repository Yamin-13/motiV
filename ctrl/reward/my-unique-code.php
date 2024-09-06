<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/reward.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/transaction.php';

$titrePage = "motiV";
$dbConnection = getConnection($dbConfig); // Connexion à la base de données

// Vérification que l'utilisateur est bien un jeune
if (!isset($_SESSION['user']) || $_SESSION['user']['idRole'] != 60) {
    $_SESSION['error'] = "Vous n'avez pas la permission d'accéder à cette page.";
    header('Location: /ctrl/login/login-display.php');
    exit();
}

$idUser = $_SESSION['user']['id']; // Récupère l'id du jeune connecté
$codes = getUserCodes($idUser, $dbConnection); // Récupère les codes échangés par le jeune

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/reward/my-unique-code.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';