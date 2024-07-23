<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';

$titrePage = "motiV";

if (isset($_GET['role'])) {
    $role = $_GET['role'];
    $idRole = ($role == 'partner') ? 40 : 50; // 40 pour Partenaire, 50 pour Association

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $dbConnection = getConnection($dbConfig);

        if (addUser($email, $hashedPassword, $idRole, $dbConnection)) {
            $_SESSION['success'] = 'Inscription réussie.<br>Vous pouvez maintenant vous connecter.';
            header('Location: /ctrl/login/login-display.php');
            exit();
        } else {
            $_SESSION['error'] = 'Erreur lors de l\'inscription.<br> Veuillez réessayer.';
            header('Location: /ctrl/login/login-display.php');
            exit();
        }
    } else {
        include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
        include $_SERVER['DOCUMENT_ROOT'] . '/view/register/register-entity.php';
        include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';
    }
} else {
    echo "Rôle non défini.";
}

