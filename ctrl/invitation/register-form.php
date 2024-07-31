<?php
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/invitation.php';
session_start();

$dbConnection = getConnection($dbConfig);

$token = $_GET['token'];
$invitation = getInvitationByToken($token, $dbConnection);

if (!$invitation || new DateTime($invitation['expiry']) < new DateTime()) {
    die('Invitation invalide ou expirée.');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $firstName = $_POST['first_name'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $roleId = ($invitation['entity_type'] == 'association') ? 40 : 50;

    if (addUser($email, $name, $firstName, $password, $roleId, $dbConnection)) {
        $_SESSION['success'] = 'Inscription réussie.';
        header('Location: /ctrl/login/login-display.php');
        exit();
    } else {
        $_SESSION['error'] = 'Erreur lors de l\'inscription.';
    }
}

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/invitation/register-form.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';