<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/reward.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';

// Connexion à la base de données
$dbConnection = getConnection($dbConfig);
$titrePage = "Historique des récompenses – La plateforme qui valorise l'effort";

// Vérifie que l'utilisateur est connecté et a le rôle jeune
if (!isset($_SESSION['user']) || $_SESSION['user']['idRole'] != 60) {
    $_SESSION['error'] = "Vous n'avez pas la permission d'accéder à cette page.";
    header('Location: /ctrl/login/login-display.php');
    exit();
}

$idUser = $_SESSION['user']['id'];

// Récupére l'historique des achats
$purchases = getUserPurchaseHistory($idUser, $dbConnection);

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/reward/purchase-history.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';