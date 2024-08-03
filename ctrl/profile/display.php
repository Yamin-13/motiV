<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/association.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/partner.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/verification.php';

$titrePage = "motiV";

// Vérification du rôle de l'utilisateur
$idRole = $_SESSION['user']['idRole'];
if (!in_array($idRole, [10, 40, 45, 50, 55])) {
    // Si l'utilisateur a pas un des rôles appropriés, redirige vers la page de connexion
    header('Location: /ctrl/login/login-display.php');
    exit();
}

$dbConnection = getConnection($dbConfig);
$user = $_SESSION['user'];

if ($idRole == 50 || $idRole == 55) {
    $association = ($idRole == 50) ? getAssociationByidUser($user['id'], $dbConnection) : getAssociationByidMember($user['id'], $dbConnection);
    $members = getMembersByAssociationId($association['id'], $dbConnection);
    include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/view/profile/association-display.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';
} elseif ($idRole == 40 || $idRole == 45) {
    $partner = ($idRole == 40) ? getPartnerByidUser($user['id'], $dbConnection) : getPartnerByidMember($user['id'], $dbConnection);
    $members = getMembersByPartnerId($partner['id'], $dbConnection);
    include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/view/profile/partner-display.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';
}