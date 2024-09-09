<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/association.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/partner.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/verification.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/city-hall.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/educational-establishment.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/contact.php';

$titrePage = "motiV";

// Vérification du rôle de l'utilisateur
$idRole = $_SESSION['user']['idRole'];
if ($idRole != 10) {
    // Si l'utilisateur n'est pas un admin, redirige vers la page de connexion
    header('Location: /ctrl/login/login-display.php');
    exit();
}

// données nécessaires
$dbConnection = getConnection($dbConfig);
$pendingAssociations = getPendingAssociations($dbConnection);
$pendingPartners = getPendingPartners($dbConnection);
$associations = getAssociationsWithPresidents($dbConnection);
$cityHalls = getCityHallsWithAdmins($dbConnection);
$educationalEstablishments = getEducationalEstablishmentsWithAdmins($dbConnection);
// récupération des messages pour l'admin
$messages = getMessagesForAdmin($dbConnection);

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/admin/profile.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';