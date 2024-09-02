<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/reward.php';

// Connexion à la base de données
$dbConnection = getConnection($dbConfig);

// Vérifie que l'utilisateur est connecté et a le rôle 'jeune'
if (!isset($_SESSION['user']) || $_SESSION['user']['idRole'] != 60) {
    $_SESSION['error'] = "Vous n'avez pas la permission d'accéder à cette page.";
    header('Location: /ctrl/login/login-display.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idReward = intval($_POST['idReward']);
    $idUser = $_SESSION['user']['id'];

    // Récupére les information de la récompense
    $reward = getRewardById($idReward, $dbConnection);

    if (!$reward) {
        $_SESSION['error'] = "Récompense introuvable.";
        header('Location: /ctrl/reward/rewards.php');
        exit();
    }

    // Vérifie la disponibilité de la récompense
    if ($reward['quantity_available'] <= 0) {
        $_SESSION['error'] = "Cette récompense n'est plus disponible.";
        header('Location: /ctrl/reward/rewards.php');
        exit();
    }

    // Vérifie si l'utilisateur a suffisamment de point
    $userPoints = fetchUserRewardPoints($idUser, $dbConnection);
    if ($userPoints < $reward['reward_price']) {
        $_SESSION['error'] = "Vous n'avez pas assez de points pour échanger cette récompense.";
        header('Location: /ctrl/reward/rewards.php');
        exit();
    }

    // Déduire les point de l'utilisateur
    $deducted = deductUserPoints($idUser, $reward['reward_price'], $dbConnection);
    if (!$deducted) {
        $_SESSION['error'] = "Erreur lors de la déduction des points.";
        header('Location: /ctrl/reward/rewards.php');
        exit();
    }

    // Génère un code unique
    $unique_code = generateUniqueCode();

    // Insére la transaction
    $transaction = insertTransaction($idUser, $idReward, $reward['reward_price'], $unique_code, $dbConnection);
    if (!$transaction) {
        $_SESSION['error'] = "Erreur lors de l'enregistrement de la transaction.";
        header('Location: /ctrl/reward/rewards.php');
        exit();
    }

    // Décrémente la quantité disponible
    $updated = updateRewardQuantity($idReward, $dbConnection);
    if (!$updated) {
        $_SESSION['error'] = "Erreur lors de la mise à jour de la récompense.";
        header('Location: /ctrl/reward/rewards.php');
        exit();
    }

    // affiche le code unique 
    $_SESSION['success'] = "Récompense échangée avec succès. Votre code unique est : " . $unique_code;
    header('Location: /ctrl/reward/rewards.php');
    exit();
} else {
    $_SESSION['error'] = "Méthode de requête non autorisée.";
    header('Location: /ctrl/reward/rewards.php');
    exit();
}