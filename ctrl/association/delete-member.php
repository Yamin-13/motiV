<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/association.php';

$dbConnection = getConnection($dbConfig);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idUser = $_POST['idUser'];
    $query = "DELETE FROM association_user WHERE idUser = :idUser";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idUser', $idUser);
    if ($statement->execute()) {
        $_SESSION['success'] = "Membre supprimé avec succès.";
    } else {
        $_SESSION['error'] = "Erreur lors de la suppression du membre.";
    }
    header('Location: /ctrl/profile.php');
    exit();
}