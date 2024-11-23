<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/association.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/partner.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/educational-establishment.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/city-hall.php';

$titrePage = "Formulaire d'Invitation | MotiV – La plateforme qui valorise l'effort";

$dbConnection = getConnection($dbConfig);

$user = $_SESSION['user'];
$association = getAssociationByidUser($user['id'], $dbConnection);
$partner = getPartnerByidUser($user['id'], $dbConnection);
$educationalEstablishment = getEducationalEstablishmentByIdUser($user['id'], $dbConnection);
$cityHall = getCityHallByIdUser($user['id'], $dbConnection);

if ($association) {
    $entityType = 'association';
    $entityId = $association['id'];
} elseif ($partner) {
    $entityType = 'partner';
    $entityId = $partner['id'];
} elseif ($educationalEstablishment) {
    $entityType = 'educational_establishment';
    $entityId = $educationalEstablishment['id'];
} elseif ($cityHall) {
    $entityType = 'city_hall';
    $entityId = $cityHall['id'];
} else {
    $_SESSION['error'] = "Aucune entité associée trouvée.";
    header('Location: /ctrl/profile/display.php');
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/invitation/send-invitation-form.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';