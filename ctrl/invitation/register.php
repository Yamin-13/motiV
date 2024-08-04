<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/invitation.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';

$dbConnection = getConnection($dbConfig);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['invitation'])) {
        die('Session d\'invitation invalide.');
    }

    $invitation = $_SESSION['invitation'];
    $email = $invitation['email'];
    $name = $_POST['name'];
    $firstName = $_POST['first_name'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $idRole = $invitation['idRole'];
    $associationId = $invitation['idAssociation'];
    $partnerId = $invitation['idPartner'];

    if (addUser($email, $name, $firstName, $password, $idRole, $fileName, $dateOfBirth, $address, $dbConnection)) {
        $userId = $dbConnection->lastInsertId();

        // Lier l'utilisateur à l'association ou au partenaire
        if ($associationId) {
            $query = 'INSERT INTO association_user (idAssociation, idUser, role) VALUES (:idAssociation, :idUser, "member")';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':idAssociation', $associationId);
        } else {
            $query = 'INSERT INTO partner_user (idPartner, idUser, role) VALUES (:idPartner, :idUser, "member")';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':idPartner', $partnerId);
        }
        $statement->bindParam(':idUser', $userId);
        $statement->execute();

        deleteInvitation($invitation['id'], $dbConnection);
        unset($_SESSION['invitation']);

        $_SESSION['success'] = "Inscription réussie. Vous pouvez maintenant vous connecter.";
        header('Location: /ctrl/login/login-display.php');
        exit();
    } else {
        $_SESSION['error'] = "Erreur lors de l'inscription.";
        header('Location: /ctrl/invitation/register-form.php');
        exit();
    }
}