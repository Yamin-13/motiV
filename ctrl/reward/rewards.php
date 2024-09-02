<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/reward.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';

// Connexion à la base de donnée
$dbConnection = getConnection($dbConfig);
$titrePage = "motiV";

// Récupére toute les récompenses disponible
$rewards = getAllRewards($dbConnection);

// Récupére le nom du submitteur (partenaire ou mairie) pour chaque récompense
foreach ($rewards as &$reward) {
    $reward['submitter_name'] = getSubmitterName($reward, $dbConnection);
}

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/reward/rewards.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';