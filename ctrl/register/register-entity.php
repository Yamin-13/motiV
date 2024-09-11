<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';

// se connecte à la BDD
$dbConnection = getConnection($dbConfig);

$titrePage = "motiV";

if (isset($_GET['role'])) {
    $role = $_GET['role'];
    $idRole = ($role == 'partner') ? 40 : 50;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = htmlspecialchars($_POST['email']);
        $name = htmlspecialchars($_POST['name']);
        $firstName = htmlspecialchars($_POST['first_name']);
        $password = htmlspecialchars($_POST['password']);
        $confirmPassword = htmlspecialchars($_POST['confirm_password']);
        $dateOfBirth = htmlspecialchars($_POST['date_of_birth'] ?? '');
        $address = htmlspecialchars($_POST['address'] ?? '');
        $points = 0;
        $ine_number = htmlspecialchars($_POST['ine_number'] ?? '');

        // Enregistre les donnée du formulaire dans la session pour les pré remplir en cas d'erreur
        $_SESSION['form_data'] = [
            'name' => $name,
            'first_name' => $firstName,
            'email' => $email,
        ];

        // Vérification des mots de passe
        if ($password !== $confirmPassword) {
            $_SESSION['error'] = 'Les mots de passe ne correspondent pas.';
            include $_SERVER['DOCUMENT_ROOT'] . '/ctrl/register/register-entity.php';
            exit();
        }

        // Vérifie si l'email existe déjà
        if (emailExists($email, $dbConnection)) {
            $_SESSION['error'] = 'L\'email existe déjà. Veuillez en utiliser un autre.';
            include $_SERVER['DOCUMENT_ROOT'] . '/ctrl/register/register-entity.php';
            exit();
        }

        // Hash du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        if ($dbConnection) {
            if (addUser($email, $name, $firstName, $hashedPassword, $idRole, "", $dateOfBirth, $address, $points, $ine_number, $dbConnection)) {
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
                    include $_SERVER['DOCUMENT_ROOT'] . '/ctrl/register/register-entity.php';
                    exit();
                }
            } else {
                $_SESSION['error'] = 'Erreur lors de l\'inscription.<br> Veuillez réessayer.';
                include $_SERVER['DOCUMENT_ROOT'] . '/ctrl/register/register-entity.php';
                exit();
            }
        } else {
            $_SESSION['error'] = 'Erreur de connexion à la base de données.';
            include $_SERVER['DOCUMENT_ROOT'] . '/ctrl/register/register-entity.php';
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