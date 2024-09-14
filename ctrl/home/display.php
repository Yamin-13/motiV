<?php
session_start(); // ca initialise une session et permet à $_SESSION de fonctionner (de stocker dans les coockies) 
require_once $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';

// connexion à la base de données
$dbConnection = getConnection($dbConfig);

$titrePage = "motiV";

// Vérifie si l'utilisateur est connecté
if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) {
    // Récupère l'ID utilisateur de la session
    $userId = $_SESSION['user']['id'];

    // Récupère les informations de l'utilisateur
    $user = getUserById($userId, $dbConnection);
} else {
    // L'utilisateur n'est pas connecté $user sera null
    $user = null;
}

// rend la vue
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';

// Vérifie si $user est défini et que c'est un jeune qui a le profil incomplet
if ($user && isset($user['idRole']) && $user['idRole'] == 60 && isset($user['profile_complete']) && $user['profile_complete'] == 0) {
    // Le profil n'est pas complet et l'utilisateur est un jeune ca affiche le message de demande de complété le profil
    include $_SERVER['DOCUMENT_ROOT'] . '/view/home/incomplete-profile-message.php';
}
include $_SERVER['DOCUMENT_ROOT'] . '/view/home/display.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';