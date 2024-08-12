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
    $educationalEstablishmentId = $invitation['idEducationalEstablishment'] ?? null;
    $cityHallId = $invitation['idCityHall'] ?? null;

    var_dump($associationId, $partnerId, $educationalEstablishmentId, $cityHallId);

    if (addUser($email, $name, $firstName, $password, $idRole, '', '', '', $dbConnection)) {
        $userId = $dbConnection->lastInsertId();

        // Lier l'utilisateur à l'entité appropriée
        $query = null;

        if ($associationId) {
            $query = 'INSERT INTO association_user (idAssociation, idUser, role) VALUES (:idAssociation, :idUser, "member")';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':idAssociation', $associationId);
        } elseif ($partnerId) {
            $query = 'INSERT INTO partner_user (idPartner, idUser, role) VALUES (:idPartner, :idUser, "member")';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':idPartner', $partnerId);
        } elseif ($educationalEstablishmentId) {
            $query = 'INSERT INTO educational_establishment_user (idEducationalEstablishment, idUser, role) VALUES (:idEducationalEstablishment, :idUser, "member")';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':idEducationalEstablishment', $educationalEstablishmentId);
        } elseif ($cityHallId) {
            $query = 'INSERT INTO city_hall_user (idCityHall, idUser, role) VALUES (:idCityHall, :idUser, "member")';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':idCityHall', $cityHallId);
        }

        // Si la requête a été définie, on exécute l'insertion
        if (isset($statement)) {
            $statement->bindParam(':idUser', $userId);
            $statement->execute();
        } else {
            // Si aucune condition n'est remplie, afficher une erreur
            $_SESSION['error'] = "Erreur : aucune entité valide pour l'utilisateur.";
            header('Location: /ctrl/invitation/register-form.php');
            exit();
        }

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