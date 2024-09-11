<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/message.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/point.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/mission.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/contact.php';

$titrePage = "motiV";

// connexion à la base de données
$dbConnection = getConnection($dbConfig);

// Récupére l'ID utilisateur de la session
$userId = $_SESSION['user']['id'];

// Récupére les information mises à jour de l'utilisateur depuis la base de donnée
$user = getUserById($userId, $dbConnection);

// Met à jour toutes les informations de l'utilisateur dans la session
$_SESSION['user']['name'] = $user['name'];
$_SESSION['user']['first_name'] = $user['first_name'];
$_SESSION['user']['email'] = $user['email'];
$_SESSION['user']['ine_number'] = $user['ine_number'];
$_SESSION['user']['date_of_birth'] = $user['date_of_birth'];
$_SESSION['user']['address'] = $user['address'];
$_SESSION['user']['avatar_filename'] = $user['avatar_filename'];
$_SESSION['user']['registration_date'] = $user['registration_date'];
$_SESSION['user']['points'] = $user['points'];
$_SESSION['user']['last_connexion'] = $user['last_connexion'];

$pointLogs = getPointLogs($userId, $dbConnection);

// Fonction pour récupérer les messages envoyés par le jeune à l'admin
$sentMessages = getContactMessagesByUser($user['id'], $dbConnection);

// Fonction pour récupérer les réponses de l'admin à ce jeune
$receivedMessages = getMessagesByidUser($user['id'], $dbConnection);


// Vérifie le rôle de l'utilisateur
$idRole = $_SESSION['user']['idRole'];
if ($idRole == 60) {
    include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/view/young/profile.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';
} else {
    // Redirige l'utilisateur s'il n'est pas un jeune
    header('Location: /ctrl/login/login-display.php');
}