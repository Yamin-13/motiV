<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/reward.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';

// Connexion à la base de données
$dbConnection = getConnection($dbConfig);
$titrePage = "motiV";

// Vérifie que l'ID de la récompense est présent
if (!isset($_GET['idReward'])) {
    $_SESSION['error'] = "Récompense introuvable.";
    header('Location: /ctrl/reward/rewards.php');
    exit();
}

$idReward = intval($_GET['idReward']);
$reward = getRewardById($idReward, $dbConnection);
$reward['submitter_name'] = getSubmitterName($reward, $dbConnection);

if (!$reward) {
    $_SESSION['error'] = "Récompense introuvable.";
    header('Location: /ctrl/reward/rewards.php');
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/reward/reward-details.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';