<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/city-hall.php';

$dbConnection = getConnection($dbConfig);
$titrePage = "Liste des Mairies | MotiV – La plateforme qui valorise l'effort";


// Vérification du rôle de l'utilisateur
$idRole = $_SESSION['user']['idRole'];
if ($idRole != 10) {
    // Si l'utilisateur n'est pas un admin, redirige vers la page de connexion
    header('Location: /ctrl/login/login-display.php');
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/city-hall/list.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';