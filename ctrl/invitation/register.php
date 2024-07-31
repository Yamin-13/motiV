<?php
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/invitation.php';

$dbConnection = getConnection($dbConfig);

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['token'])) {
    $token = $_GET['token'];
    $invitation = getInvitationByToken($token, $dbConnection);

    if (!$invitation) {
        die('Invitation invalide ou expirée.');
    }

    // Stocker l'invitation dans la session pour l'utiliser lors de l'inscription
    $_SESSION['invitation'] = $invitation;
    header('Location: /ctrl/invitation/register-form.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['invitation'])) {
        die('Session d\'invitation invalide.');
    }

    $invitation = $_SESSION['invitation'];
    $email = $invitation['email'];
    $name = $_POST['name'];
    $firstName = $_POST['first_name'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $idRole = 30; // Role de membre
    $associationId = $invitation['association_id'];

    if (addUser($email, $name, $firstName, $password, $idRole, $dbConnection)) {
        $userId = $dbConnection->lastInsertId();

        // Ajouter l'utilisateur à l'association
        $query = 'INSERT INTO association_user (association_id, idUser, role) VALUES (:association_id, :idUser, :role)';
        $statement = $dbConnection->prepare($query);
        $statement->bindParam(':association_id', $associationId);
        $statement->bindParam(':idUser', $userId);
        $statement->bindParam(':role', $idRole);
        $statement->execute();

        deleteInvitation($invitation['id'], $dbConnection);
        unset($_SESSION['invitation']);

        $_SESSION['success'] = "Inscription réussie. Vous pouvez maintenant vous connecter.";
        header('Location: /ctrl/login/login.php');
        exit();
    } else {
        $_SESSION['error'] = "Erreur lors de l'inscription.";
        header('Location: /ctrl/invitation/register-form.php');
        exit();
    }
}
