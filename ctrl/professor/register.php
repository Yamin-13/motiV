<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/professor.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/educational-establishment.php';

$dbConnection = getConnection($dbConfig);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $first_name = $_POST['first_name'];
    $class_name = $_POST['class_name'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $_SESSION['error'] = 'Les mots de passe ne correspondent pas.';
        header('Location: /ctrl/professor/registration-form.php');
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Vérifie si l'email existe déjà
    if (emailExists($email, $dbConnection)) {
        $_SESSION['error'] = 'L\'email existe déjà. Veuillez en utiliser un autre.';
        header('Location: /ctrl/professor/registration-form.php');
        exit();
    }

    // Ajouter l'utilisateur avec le rôle de professeur (idRole = 27)
    $userId = addUser($email, $name, $first_name, $hashedPassword, 27, '', '', '', '', '', $dbConnection);

    if ($userId) {
        // Ajouter le professeur dans la table professor_user
        $establishmentId = $_SESSION['establishment_id'];
        addProfessorUser($userId, $establishmentId, $class_name, $dbConnection);

        // Rediriger vers la page de profil
        $_SESSION['user'] = getUserById($userId, $dbConnection);
        header('Location: /ctrl/profile/display.php');
        exit();
    } else {
        $_SESSION['error'] = 'Erreur lors de l\'inscription.';
        header('Location: /ctrl/professor/registration-form.php');
        exit();
    }
}