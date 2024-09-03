<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/reward.php';

// Connexion à la base de données
$dbConnection = getConnection($dbConfig);

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header('Location: /ctrl/login/login-display.php');
    exit();
}

// Vérifie le rôle
$idRole = $_SESSION['user']['idRole'];
$idUser = $_SESSION['user']['id'];
$idReward = intval($_POST['idReward']);

// Récupère la récompense pour vérifier l'autorisation
$reward = getRewardById($idReward, $dbConnection);

if (!$reward) {
    $_SESSION['error'] = "Récompense introuvable.";
    header('Location: /ctrl/reward/rewards.php');
    exit();
}

// Vérifie si l'utilisateur est autorisé à supprimer la récompense (admin ou submiter)
if ($idRole != 10 && $reward['idUser'] != $idUser) {
    $_SESSION['error'] = "Vous n'avez pas la permission de supprimer cette récompense.";
    header('Location: /ctrl/reward/rewards.php');
    exit();
}

// Supprime la récompense
$deleted = deleteReward($idReward, $dbConnection);

if ($deleted) {
    $_SESSION['success'] = "Récompense supprimée avec succès.";
} else {
    $_SESSION['error'] = "Erreur lors de la suppression de la récompense.";
}

header('Location: /ctrl/reward/rewards.php');
exit();