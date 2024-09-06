<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/reward.php';

// Connexion à la base de données
$dbConnection = getConnection($dbConfig);

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    $_SESSION['error'] = "Veuillez vous connecter.";
    header('Location: /ctrl/login/login-display.php');
    exit();
}

// Récupère l'ID de la récompense
$idReward = $_GET['id'] ?? null;

if (!$idReward) {
    $_SESSION['error'] = "Récompense non trouvée.";
    header('Location: /ctrl/profile/display.php');
    exit();
}

// Récupère les détails de la récompense
$reward = getRewardById($idReward, $dbConnection);

// Vérifie que l'utilisateur est bien le propriétaire de la récompense
$idUser = $_SESSION['user']['id'];
if ($reward['idUser'] != $idUser) {
    $_SESSION['error'] = "Vous n'avez pas la permission de modifier cette récompense.";
    header('Location: /ctrl/profile/display.php');
    exit();
}

// Traitement de la soumission du formulaire de mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $reward_price = trim($_POST['reward_price']);
    $quantity_available = trim($_POST['quantity_available']);
    $idCategory = trim($_POST['idCategory']);
    
    // Met à jour la récompense
    $updated = updateReward($idReward, $title, $description, $reward_price, $quantity_available, $idCategory, $dbConnection);

    if ($updated) {
        $_SESSION['success'] = "Récompense mise à jour avec succès.";
        header("Location: /ctrl/reward/reward-details.php?idReward={$idReward}");
        exit();
    } else {
        $_SESSION['error'] = "Erreur lors de la mise à jour de la récompense.";
    }
}
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/reward/update-reward.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';