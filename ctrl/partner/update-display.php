<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/partner.php';

$dbConnection = getConnection($dbConfig);
$titrePage = "motiV";

// Vérification de l'ID
if (!isset($_GET['id'])) {
    die('ID entreprise manquant.');
}

$id = $_GET['id'];
$partner = getPartnerById($id, $dbConnection);

if (!$partner) {
    die('Entreprise non trouvée.');
}

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partner/update-display.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';
