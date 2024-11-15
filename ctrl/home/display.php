<?php
session_start(); // Initialise la session
require_once $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/lib/mission.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/lib/reward.php';

// Connexion à la base de données
$dbConnection = getConnection($dbConfig);

$titrePage = "Accueil | MotiV – La plateforme qui valorise l'effort";

// Vérifie si l'utilisateur est connecté
if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) {
    // Récupère l'ID utilisateur de la session
    $userId = $_SESSION['user']['id'];

    // Récupère les informations de l'utilisateur
    $user = getUserById($userId, $dbConnection);

    // Définit la variable profileComplete
    $profileComplete = isset($user['profile_complete']) ? $user['profile_complete'] : 0;
} else {
    // L'utilisateur n'est pas connecté $user et $profileComplete seront définis par défaut
    $user = null;
    $profileComplete = 0;
}

// Récupère toutes les missions disponibles
$missions = getAllMissions($dbConnection);

// Récupère les dernières missions, les 5 plus récentes
$latestMissions = getLatestMissions($dbConnection, 8);

// Récupère des récompenses aléatoires
$randomRewards = getRandomRewards($dbConnection, 8);

// Récupère le nom du submitter (partenaire ou mairie) pour chaque récompense
foreach ($randomRewards as $key => $reward) {
    $randomRewards[$key]['submitter_name'] = getSubmitterName($reward, $dbConnection);
}

// Formate les dates et heures et calcule la durée pour chaque mission récente
foreach ($latestMissions as $key => $mission) {
    $latestMissions[$key]['start_date_formatted'] = date('d/m/Y', strtotime($mission['start_date_mission']));
    $latestMissions[$key]['start_time_formatted'] = date('H:i', strtotime($mission['start_date_mission']));
    $latestMissions[$key]['end_date_formatted'] = date('d/m/Y', strtotime($mission['end_date_mission']));
    $latestMissions[$key]['end_time_formatted'] = date('H:i', strtotime($mission['end_date_mission']));
}

// Rend la vue
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';

// Vérifie si $user est défini et que c'est un jeune qui a le profil incomplet
if ($user && isset($user['idRole']) && $user['idRole'] == 60 && $profileComplete == 0) {
    // Le profil n'est pas complet et l'utilisateur est un jeune ca affiche le message de demande de compléter le profil
    include $_SERVER['DOCUMENT_ROOT'] . '/view/home/incomplete-profile-message.php';
}

include $_SERVER['DOCUMENT_ROOT'] . '/view/home/display.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';