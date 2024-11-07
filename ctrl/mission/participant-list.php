<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/mission.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/association.php';

$dbConnection = getConnection($dbConfig);
$titrePage = "MotiV";

if (!isset($_SESSION['user']['idAssociation'])) {
    $idAssociation = getAssociationIdByUserId($_SESSION['user']['id'], $dbConnection);
    $_SESSION['user']['idAssociation'] = $idAssociation;
}


// Vérification du rôle de l'utilisateur pour s'assurer qu'il s'agit bien d'une association
$idRole = $_SESSION['user']['idRole'];
if ($idRole != 50 && $idRole != 55) {
    header('Location: /ctrl/login/login-display.php');
    exit();
}

// Récupére l'ID de l'association à partir de la session
$idAssociation = $_SESSION['user']['idAssociation'];

// Récupére la liste des jeune ayant participé à des mission de l'association
$participants = getParticipantsByAssociation($idAssociation, $dbConnection);

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/mission/participant-list.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';