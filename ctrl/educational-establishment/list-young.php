<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/educational-establishment.php';

$dbConnection = getConnection($dbConfig);
$titrePage = "Liste des Jeunes de l'Établissement | MotiV – La plateforme qui valorise l'effort";

// Vérification du role de l'utilisateur
$idRole = $_SESSION['user']['idRole'];
if (!in_array($idRole, [20, 25, 27])) {
    // Si l'utilisateur n'est pas un membre d'un établissement scolaire
    header('Location: /ctrl/login/login-display.php');
    exit();
}

// Récupére l'ID de l'établissement scolaire auquel l'admin est associé
$idUser = $_SESSION['user']['id'];
$educationalEstablishment = getEducationalEstablishmentByIdUser($idUser, $dbConnection);

if (!$educationalEstablishment) {
    $_SESSION['error'] = "Établissement non trouvé.";
    header('Location: /ctrl/profile/display.php');
    exit();
}

// Récupére la liste des jeunes de cet établissement
$youngUsers = getYoungUsersByEstablishment($educationalEstablishment['id'], $dbConnection);

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/educational-establishment/list-young.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';