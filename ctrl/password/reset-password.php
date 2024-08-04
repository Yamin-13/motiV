<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/lib/password.php';

$dbConnection = getConnection($dbConfig);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $newPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);
    
    $resetRequest = getPasswordResetRequest($token, $dbConnection);
    
    if ($resetRequest && new DateTime($resetRequest['expiry']) > new DateTime()) {
        updateUserPassword($resetRequest['email'], $newPassword, $dbConnection);
        deletePasswordResetToken($token, $dbConnection);
        $_SESSION['success'] = 'Mot de passe réinitialisé avec succès.';
        header('Location: /ctrl/login/login-display.php');
        exit();
    } else {
        $_SESSION['error'] = 'Le lien de réinitialisation est invalide ou a expiré.';
        header('Location: /ctrl/password/reset-password.php?token=' . $token);
        exit();
    }
}