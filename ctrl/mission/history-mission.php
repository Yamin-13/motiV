<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/mission.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/association.php'; // Assure-toi d'inclure le fichier qui gère les associations

$dbConnection = getConnection($dbConfig);
$titrePage = "Historique des Missions";

// Vérifie que l'utilisateur est connecté et qu'il a le rôle correct
if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['idRole'], [50, 55])) {
    header('Location: /ctrl/login/login-display.php');
    exit();
}

// Vérifie si l'ID de l'association est déjà dans la session
if (!isset($_SESSION['user']['idAssociation'])) {
    // Récupère l'ID de l'association de l'utilisateur s'il n'est pas déjà dans la session
    $idAssociation = getAssociationIdByUserId($_SESSION['user']['id'], $dbConnection);
    if ($idAssociation) {
        $_SESSION['user']['idAssociation'] = $idAssociation;
    } else {
        // Gère le cas où l'utilisateur n'a pas d'association
        echo "Erreur : Association introuvable.";
        exit();
    }
} else {
    $idAssociation = $_SESSION['user']['idAssociation'];
}

$missions = getAccomplishedMissionsByAssociation($idAssociation, $dbConnection);

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/mission/history-mission.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';
