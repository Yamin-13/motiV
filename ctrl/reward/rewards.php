<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/reward.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';

// Connexion à la base de donnée
$dbConnection = getConnection($dbConfig);
$titrePage = "Récompenses | MotiV – La plateforme qui valorise l'effort";

// Vérifie si un category_id est passé dans l'URL
$categoryId = isset($_GET['category_id']) ? intval($_GET['category_id']) : null;

// Si une catégorie est sélectionnée, récupère les récompenses de cette catégorie
if ($categoryId) {
    $rewards = getRewardsByCategory($categoryId, $dbConnection);
} else {
    // Si aucune catégorie n'est sélectionnée, récupère toutes les récompenses
    $rewards = getAllRewards($dbConnection);
}

// Récupère toutes les catégories
$categories = getAllCategories($dbConnection);

// Récupére le nom du submiteur (partenaire ou mairie) pour chaque récompense
foreach ($rewards as $key => $reward) {
    $rewards[$key]['submitter_name'] = getSubmitterName($reward, $dbConnection);
}

// défini l'id de l'utilisateur connecté s'il est connecté
$idUser = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null;

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/reward/rewards.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';