<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/invitation.php';

if (isset($_GET['token'])) {
    $token = htmlspecialchars($_GET['token']);
    $dbConnection = getConnection($dbConfig);

    $invitation = getInvitationByToken($token, $dbConnection);

    if ($invitation && strtotime($invitation['expiry']) > time()) {
        $_SESSION['invitation'] = $invitation;
        include $_SERVER['DOCUMENT_ROOT'] . '/view/invitation/establisment-ch-register-form.php';
    } else {
        $_SESSION['error'] = 'Invitation invalide ou expirée.';
        header('Location: /view/login/login-display.php');
        exit();
    }
} else {
    $_SESSION['error'] = 'Aucun token fourni.';
    header('Location: /view/login/login-display.php');
    exit();
}