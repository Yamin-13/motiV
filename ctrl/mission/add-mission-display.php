<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/mission.php';

$dbConnection = getConnection($dbConfig);
$titrePage = "Formulaire d'ajout de mission | MotiV – La plateforme qui valorise l'effort";


// Vérifie que l'utilisateur est un admin ou un membre de l'association
$idRole = $_SESSION['user']['idRole'];
if ($idRole != 50 && $idRole != 55) {
    header('Location: /ctrl/login/login-display.php');
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/mission/add-mission-display.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';