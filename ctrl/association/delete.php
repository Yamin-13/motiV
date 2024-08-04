<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/association.php';

if (!isset($_GET['id'])) {
    die('ID association manquant.');
}

$id = $_GET['id'];

$dbConnection = getConnection($dbConfig);

if (deleteAssociationById($id, $dbConnection)) {
    $_SESSION['success'] = 'association supprimée avec succès.';
} else {
    $_SESSION['error'] = 'Erreur lors de la suppression de l\'association.';
}

header('Location: /ctrl/profile/display.php');
exit();