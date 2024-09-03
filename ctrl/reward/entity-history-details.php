<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/reward.php';

$dbConnection = getConnection($dbConfig); // Connexion à la base de données

// Récupère l'id de la récompense
$idReward = intval($_GET['idReward']);
$reward = getRewardById($idReward, $dbConnection);

// Vérifie si la récompense existe
if (!$reward) {
    $_SESSION['error'] = "Récompense introuvable.";
    header('Location: /ctrl/reward/entity-history.php');
    exit();
}

// Récupère la liste des jeunes ayant échangé cette récompense
$purchasers = getPurchasersByReward($idReward, $dbConnection);

$titrePage = "Détails de la récompense";
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/reward/entity-history-details.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';