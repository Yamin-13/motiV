<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';


$titrePage = "motiV";

// Récuepre l'ID utilisateur de la session
$userId = $_SESSION['user']['id'];

// connexion à la base de données
$dbConnection = getConnection($dbConfig); 

// Recupere les informations de l'utilisateur
$user = getUserById($userId, $dbConnection);

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';

// Vérifie si l'utilisateur est un jeune
if ($user['idRole'] == 60 && $user['profile_complete'] == 0) {
    // Le profil n'est pas complet et l'utilisateur est un jeune alors affiche le message
    include $_SERVER['DOCUMENT_ROOT'] . '/view/home/incomplete-profile-message.php';
}

include $_SERVER['DOCUMENT_ROOT'] . '/view/home/welcome.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';