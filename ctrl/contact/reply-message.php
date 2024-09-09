<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/model/lib/contact.php';

// Connexion à la base de données
$dbConnection = getConnection($dbConfig);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $messageId = $_POST['message_id'];
    $adminResponse = trim($_POST['admin_response']);

    if (!empty($adminResponse)) {
        if (replyToContactMessage($messageId, $adminResponse, $dbConnection)) {
            $_SESSION['success'] = "Réponse envoyée avec succès.";
        } else {
            $_SESSION['error'] = "Erreur lors de l'envoi de la réponse.";
        }
    } else {
        $_SESSION['error'] = "Veuillez écrire une réponse.";
    }

    header('Location: /ctrl/admin/profile.php');
    exit();
}