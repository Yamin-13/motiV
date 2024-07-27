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
        $name = htmlspecialchars($_POST['name']);
        $firstName = htmlspecialchars($_POST['first_name']);
        $password = htmlspecialchars($_POST['password']);
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $dbConnection = getConnection($dbConfig);

        if ($dbConnection) {
            if (addUser($email, $name, $firstName, $hashedPassword, $idRole, $dbConnection)) {
                $user = getUser($email, $password, $dbConnection);
                if ($user) {
                    $_SESSION['user'] = $user;
                    if ($role == 'partner') {
                        header('Location: /ctrl/register/display-register-partner.php');
                    } else {
                        header('Location: /ctrl/register/display-register-association.php');
                    }
                    exit();
                } else {
                    $_SESSION['error'] = 'Erreur lors de la récupération de l\'utilisateur.';
                    header('Location: /view/register/register-entity.php?role=' . $role);
                    exit();
                }
            } else {
                $_SESSION['error'] = 'Erreur lors de l\'inscription.<br> Veuillez réessayer.';
                header('Location: /view/register/register-entity.php?role=' . $role);
                exit();
            }
        } else {
            $_SESSION['error'] = 'Erreur de connexion à la base de données.';
            header('Location: /view/register/register-entity.php?role=' . $role);
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
