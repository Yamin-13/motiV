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
if (!in_array($idRole, [10, 40, 50])) {
    // Si l'utilisateur n'a pas un des rôles appropriés, redirige vers la page de connexion
    header('Location: /ctrl/login/login-display.php');
    exit();
}

$dbConnection = getConnection($dbConfig);
$user = $_SESSION['user'];

$association = null;
$partner = null;

if ($idRole == 50) {
    $association = getAssociationByUserId($user['id'], $dbConnection);
} elseif ($idRole == 40) {
    $partner = getPartnerByUserId($user['id'], $dbConnection);
}

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/profile/display.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';
