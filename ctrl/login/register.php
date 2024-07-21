<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';

$_SESSION['msg']['info'] = [];
$_SESSION['msg']['error'] = [];

// récupére les informations du formulaire...
$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);

// ...et hache le mot de passe
$hashedPassword = password_hash($password, PASSWORD_BCRYPT); // PASSWORD_BCRYPT ca utilise l'algorithme Blowfish qui est plus sécurisé (survole de la documentation...)

$idRole = 30; // ca donne un role pour les nouveaux utilisateurs (sampleUser)

// se connecte à la base de données
$dbConnection = getConnection($dbConfig);

// condition pour affiché les messages de succès ou d'échec
if (addUser($email, $hashedPassword, $idRole, $dbConnection)) {  // Apel de la fonction addUser avec les 4 arguments  
    $_SESSION['success'] = 'Inscription réussie.<br>Vous pouvez maintenant vous connecter.'; // le message sera stocké dans la variable de session "succes" 
    header('Location: /ctrl/login/display.php');
    exit(); // ca arrete l'execution du script ici
} else {
    $_SESSION['error'] = 'Erreur lors de l\'inscription.<br> Veuillez réessayer.';
    header('Location: /ctrl/login/display.php');
    exit();
}



