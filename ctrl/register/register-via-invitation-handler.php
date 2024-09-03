<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $email = htmlspecialchars($_POST['email']);
    $name = htmlspecialchars($_POST['name']);
    $firstName = htmlspecialchars($_POST['first_name']);
    $password = htmlspecialchars($_POST['password']);
    $confirmPassword = htmlspecialchars($_POST['confirm_password']);
    
    if ($password !== $confirmPassword) {
        $_SESSION['error'] = 'Les mots de passe ne correspondent pas.';
        header('Location: /ctrl/register/register-via-invitation.php?token=' . $token);
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $fileName = '';

    // Traitement de l'upload du nouvel avatar
    if (!empty($_FILES['avatar']['name'])) {
        $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
        $fileName = basename($_FILES['avatar']['name']);
        $uploadPath = $uploadDirectory . $fileName;

        if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadPath)) {
            die('Erreur lors de l\'upload de l\'avatar.');
        }
    }

    $dbConnection = getConnection($dbConfig);

    // Vérifier si le token est valide
    $query = 'SELECT id, email, token, expiry, idAssociation, idPartner, idEducationalEstablishment, idCityHall, idRole 
              FROM invitation 
              WHERE token = :token AND expiry > NOW()';
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':token', $token);
    $statement->execute();
    $invitation = $statement->fetch(PDO::FETCH_ASSOC);

    if ($invitation) {
        // Ajouter l'utilisateur à la base de données
        $idRole = $invitation['idRole'];
        if (addUser($email, $name, $firstName, $hashedPassword, $idRole, $fileName, '', '', '', '', $dbConnection)) {
            // Supprimer l'invitation de la base de données
            $query = 'DELETE FROM invitation WHERE token = :token';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':token', $token);
            $statement->execute();

            // Récupérer l'utilisateur
            $user = getUser($email, $password, $dbConnection);
            if ($user) {
                $_SESSION['user'] = $user;
                $_SESSION['success'] = 'Inscription réussie.';
                header('Location: /view/profile/' . ($idRole == 20 ? 'educational-establishment-profile.php' : 'city-hall-profile.php'));
                exit();
            } else {
                $_SESSION['error'] = 'Erreur lors de la récupération de l\'utilisateur.';
                header('Location: /ctrl/register/register-via-invitation.php?token=' . $token);
                exit();
            }
        } else {
            $_SESSION['error'] = 'Erreur lors de l\'inscription.<br> Veuillez réessayer.';
            header('Location: /ctrl/register/register-via-invitation.php?token=' . $token);
            exit();
        }
    } else {
        $_SESSION['error'] = 'Le lien d\'invitation est invalide ou a expiré.';
        header('Location: /view/login/login-display.php');
        exit();
    }
} else {
    header('Location: /view/login/login-display.php');
    exit();
}