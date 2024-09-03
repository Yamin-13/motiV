<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/reward.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/partner.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/city-hall.php';

$titrePage = "Historique des échanges";
$dbConnection = getConnection($dbConfig); // Connexion à la base de données
$idUser = $_SESSION['user']['id']; // Récupère l'id de l'utilisateur connecté

// Vérifie si l'utilisateur est un partenaire ou une mairie
$isPartner = $_SESSION['user']['idRole'] == 40 || $_SESSION['user']['idRole'] == 45; // rôle partenaire
$isCityHall = $_SESSION['user']['idRole'] == 30 || $_SESSION['user']['idRole'] == 35; // rôle mairie

if ($isPartner) {
    // Récupère les infos du partenaire
    $entity = getPartnerByidUser($idUser, $dbConnection);
    // Récupère l'historique des récompenses postées par ce partenaire
    $rewardsHistory = getRewardsHistoryByPartner($entity['id'], $dbConnection);
} elseif ($isCityHall) {
    // Récupère les infos de la mairie
    $entity = getCityHallByIdUser($idUser, $dbConnection);
    // Récupère l'historique des récompenses postées par cette mairie
    $rewardsHistory = getRewardsHistoryByCityHall($entity['id'], $dbConnection);
} else {
    $_SESSION['error'] = "Vous n'avez pas la permission d'accéder à cette page.";
    header('Location: /ctrl/home/display.php');
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/reward/entity-history.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';