<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';

$dbConnection = getConnection($dbConfig);
$titrePage = "Supprimer l'utilisateur | MotiV – La plateforme qui valorise l'effort";

// Vérification du rôle de l'utilisateur
$idRole = $_SESSION['user']['idRole'];
if ($idRole != 10) {
    // Si l'utilisateur n'est pas un admin, redirige vers la page de connexion
    header('Location: /ctrl/login/login-display.php');
    exit();
}

if (!isset($_GET['id'])) {
    die('ID utilisateur manquant.');
}

$id = $_GET['id'];

// Utilisation de la fonction pour supprimer l'utilisateur
if (deleteUserById($id, $dbConnection)) {
    $_SESSION['success'] = "Utilisateur supprimé.";
} else {
    $_SESSION['error'] = "Erreur lors de la suppression de l'utilisateur.";
}

// Redirection après suppression
header('Location: /ctrl/admin/list.php');
exit();
