<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/reward.php';

$dbConnection = getConnection($dbConfig); // Connexion à la base de données

$code = $_GET['code'] ?? null; // Récupère le code depuis l'URL

if ($code) {
    // Récupère les détails de la récompense et du jeune liés au code
    $reward = getRewardDetailsByCode($code, $dbConnection);

    if ($reward) {
        // Si la validation est soumise
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['validate'])) {
            $updateStatus = updateCodeStatusToUsed($code, $dbConnection); // Met à jour le statut du code à "used"
            if ($updateStatus) {
                $_SESSION['success'] = "La récompense a été validée avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de la validation de la récompense.";
            }
            header('Location: /ctrl/reward/validate.php?code=' . urlencode($code));
            exit();
        }
    } else {
        $_SESSION['error'] = "Code invalide ou déjà utilisé.";
        header('Location: /ctrl/reward/rewards.php');
        exit();
    }
} else {
    $_SESSION['error'] = "Code non fourni.";
    header('Location: /ctrl/reward/rewards.php');
    exit();
}

// Affiche la vue en passant la variable $reward à la vue
include $_SERVER['DOCUMENT_ROOT'] . '/ctrl/reward/validate-view.php';