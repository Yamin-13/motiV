<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/partner.php';

if (!isset($_GET['id'])) {
    die('ID entreprise manquant.');
}

$id = $_GET['id'];

$dbConnection = getConnection($dbConfig);

if (deletePartnerById($id, $dbConnection)) {
    $_SESSION['success'] = 'Entreprise supprimée avec succès.';
} else {
    $_SESSION['error'] = 'Erreur lors de la suppression de l\'entreprise.';
}

header('Location: /ctrl/profile/display.php');
exit();