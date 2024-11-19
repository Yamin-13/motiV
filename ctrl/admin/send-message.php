<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/message.php';

$dbConnection = getConnection($dbConfig);
$titrePage = "Envoie de message | MotiV – La plateforme qui valorise l'effort";


// Vérification du rôle de l'utilisateur
$idRole = $_SESSION['user']['idRole'];
if ($idRole != 10) {
    // Si l'utilisateur n'est pas un admin redirige vers la page de connexion
    header('Location: /ctrl/login/login-display.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['user_id'];
    $subject = htmlspecialchars($_POST['subject']);
    $body = htmlspecialchars($_POST['body']);

    if (sendMessage($userId, $subject, $body, $dbConnection)) {
        $_SESSION['success'] = "Message envoyé.";
    } else {
        $_SESSION['error'] = "Erreur lors de l'envoi du message.";
    }

    header('Location: /ctrl/admin/user-details.php?id=' . $userId);
    exit();
}
