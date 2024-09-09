<!-- Gère le formulaire de contact pour envoyer un message à l'administrateur -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/model/lib/contact.php';

// Connexion à la base de données
$dbConnection = getConnection($dbConfig);
$titrePage = "motiV";

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    $_SESSION['error'] = "Veuillez vous connecter pour envoyer un message.";
    header('Location: /ctrl/login/login-display.php');
    exit();
}

// Récupère l'ID de l'utilisateur connecté
$idUser = $_SESSION['user']['id'];

// Si le formulaire est soumis (méthode POST) on récupère les informations
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject = trim($_POST['subject']);  // trim retire les espaces inutiles
    $body = trim($_POST['body']);        

    if (!empty($subject) && !empty($body)) {
        // Appelle la fonction pour envoyer le message à l'admin
        if (sendContactMessageToAdmin($idUser, $subject, $body, $dbConnection)) {
            $_SESSION['success'] = "Message envoyé avec succès.";
        } else {
            $_SESSION['error'] = "Erreur lors de l'envoi du message.";
        }
        header('Location: /ctrl/contact/contact-display.php');
        exit();
    } else {
        $_SESSION['error'] = "Veuillez remplir tous les champs.";
    }
}

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/contact/contact-display.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';