<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/association.php';

$dbConnection = getConnection($dbConfig);
$titrePage = "motiV";

// Vérification de l'ID
if (!isset($_GET['id'])) {
    die('ID association manquant.');
}

$id = $_GET['id'];
$association = getAssociationById($id, $dbConnection);

if (!$association) {
    die('Association non trouvée.');
}

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/association/update-display.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';
