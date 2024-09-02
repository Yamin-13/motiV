<?php
// gère  l'affichage du formulaire de soumission de récompense
session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/reward.php';

// connexion à la base de données
$dbConnection = getConnection($dbConfig);
$titrePage = "motiV";

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header('Location: /ctrl/login/login-display.php');
    exit();
}

// Vérifie le rôle de l'utilisateur
$idRole = $_SESSION['user']['idRole'];
$allowedRoles = [30, 40];

if (!in_array($idRole, $allowedRoles)) {
    $_SESSION['error'] = "Vous n'avez pas la permission d'accéder à cette page.";
    header('Location: /ctrl/profile/profile.php');
    exit();
}

// Récupére les catégorie disponible
$categories = getAllCategories($dbConnection);

// Vérifie si l'ID de la mairie ou du partenaire est passé dans l'URL
$idCityHall = $_GET['idCityHall'] ?? null;
$idPartner = $_GET['idPartner'] ?? null;

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/reward/submit-reward.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';