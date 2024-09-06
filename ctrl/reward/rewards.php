<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/reward.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';

// Connexion à la base de donnée
$dbConnection = getConnection($dbConfig);
$titrePage = "motiV";

// Récupére toute les récompense disponible
$rewards = getAllRewards($dbConnection);

// Récupére le nom du submiteur (partenaire ou mairie) pour chaque récompense
foreach ($rewards as $key => $reward) {
    $rewards[$key]['submitter_name'] = getSubmitterName($reward, $dbConnection);
}

// défini l'id de l'utilisateur connecté s'il est connecté
$idUser = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null;

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/reward/rewards.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';