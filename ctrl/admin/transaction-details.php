<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/reward.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/transaction.php';

$dbConnection = getConnection($dbConfig);
$titrePage = "Détails de la Transaction | MotiV – La plateforme qui valorise l'effort";

// Vérifie que l'utilisateur est connecté et est un admin
if (!isset($_SESSION['user']) || $_SESSION['user']['idRole'] != 10) {
    $_SESSION['error'] = "Vous n'avez pas la permission d'accéder à cette page.";
    header('Location: /ctrl/login/login-display.php');
    exit();
}

// Vérifie que l'ID de la récompense est passé en paramètre
if (!isset($_GET['idReward'])) {
    $_SESSION['error'] = "Récompense introuvable.";
    header('Location: /ctrl/admin/admin-transactions.php');
    exit();
}

$idReward = intval($_GET['idReward']);

// Récupére les détails de la récompense
$reward = getRewardById($idReward, $dbConnection);

if (!$reward) {
    $_SESSION['error'] = "Récompense introuvable.";
    header('Location: /ctrl/admin/admin-transactions.php');
    exit();
}

// Récupére la liste des jeunes ayant acheté la récompense
$purchasers = getPurchasersByReward($idReward, $dbConnection);

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/admin/transaction-details.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';
