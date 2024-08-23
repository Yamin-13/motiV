<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/invitation.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dbConnection = getConnection($dbConfig);
    $invitation = $_SESSION['invitation'];
    
    $email = htmlspecialchars($_POST['email']);
    $name = htmlspecialchars($_POST['name']);
    $firstName = htmlspecialchars($_POST['first_name']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $idRole = $invitation['idRole'];
    
    if ($_POST['password'] !== $_POST['confirm_password']) {
        $_SESSION['error'] = 'Les mots de passe ne correspondent pas.';
        header('Location: /view/invitation/register-form.php?token=' . $invitation['token']);
        exit();
    }

    if (addUser($email, $name, $firstName, $password, $idRole, '', '', '', '','', $dbConnection)) {
        deleteInvitation($invitation['id'], $dbConnection);
        $_SESSION['user'] = getUserByEmail($email, $dbConnection);
        
        if ($idRole == 20) {
            header('Location: /view/educational-establishment/add-educational-establishment.php');
        } elseif ($idRole == 30) {
            header('Location: /view/city-hall/add-city-hall.php');
        } else {
            header('Location: /view/home/display.php');
        }
        exit();
    } else {
        $_SESSION['error'] = 'Erreur lors de l\'inscription.';
        header('Location: /view/invitation/register-form.php?token=' . $invitation['token']);
        exit();
    }
}