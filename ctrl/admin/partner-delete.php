<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/partner.php';

$dbConnection = getConnection($dbConfig);

if (!isset($_GET['id'])) {
    die('ID du partenaire manquant.');
}

$id = $_GET['id'];

if (deletePartnerById($id, $dbConnection)) {
    $_SESSION['success'] = "Entreprise supprimée.";
} else {
    $_SESSION['error'] = "Erreur lors de la suppression de l'entreprise.";
}

header('Location: /ctrl/partner/list.php');