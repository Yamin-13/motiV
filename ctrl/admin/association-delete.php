<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/association.php';

$dbConnection = getConnection($dbConfig);

if (!isset($_GET['id'])) {
    die('ID de l\'association manquant.');
}

$id = $_GET['id'];

if (deleteAssociationById($id, $dbConnection)) {
    $_SESSION['success'] = "Association supprimée.";
} else {
    $_SESSION['error'] = "Erreur lors de la suppression de l'association.";
}

header('Location: /ctrl/association/list.php');