<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/invitation.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dbConnection = getConnection($dbConfig);
    $invitation = $_SESSION['invitation'] ?? null;

    if (!$invitation) {
        $_SESSION['error'] = "L'invitation est invalide ou a expiré.";
        include $_SERVER['DOCUMENT_ROOT'] . '/view/invitation/establisment-ch-register-form.php';
        exit();
    }

    // Récupération des données du formulaire
    $email = htmlspecialchars($_POST['email']);
    $name = htmlspecialchars($_POST['name']);
    $firstName = htmlspecialchars($_POST['first_name']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $idRole = $invitation['idRole'];

    // Enregistrer les données du formulaire dans la session pour les pré-remplir en cas d'erreur
    $_SESSION['form_data'] = [
        'name' => $name,
        'first_name' => $firstName,
        'email' => $email,
    ];

    // Vérification des mots de passe
    if ($password !== $confirmPassword) {
        $_SESSION['error'] = 'Les mots de passe ne correspondent pas.';
        include $_SERVER['DOCUMENT_ROOT'] . '/view/invitation/establisment-ch-register-form.php';
        exit();
    }

    // Hash du mot de passe
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Ajout de l'utilisateur
    if (addUser($email, $name, $firstName, $hashedPassword, $idRole, '', '', '', '', '', $dbConnection)) {
        // Suppression de l'invitation après l'inscription réussie
        deleteInvitation($invitation['id'], $dbConnection);

        // Connexion automatique de l'utilisateur
        $_SESSION['user'] = getUserByEmail($email, $dbConnection);

        // Redirection en fonction du rôle
        if ($idRole == 20) {
            header('Location: /view/educational-establishment/add-educational-establishment.php');
        } elseif ($idRole == 30) {
            header('Location: /view/city-hall/add-city-hall.php');
        } else {
            header('Location: /view/home/display.php');
        }
        exit();
    } else {
        // En cas d'erreur d'inscription
        $_SESSION['error'] = "Une erreur est survenue lors de l'inscription. Veuillez réessayer.";
        include $_SERVER['DOCUMENT_ROOT'] . '/view/invitation/establisment-ch-register-form.php';
        exit();
    }
}