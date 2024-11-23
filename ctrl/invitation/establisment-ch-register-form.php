<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';

$titrePage = "Formulaire D'inscription d'Etablissement scolaire | MotiV – La plateforme qui valorise l'effort";


// initialise les variable de session si elles sont pas définie
if (!isset($_SESSION['form_data'])) {
    $_SESSION['form_data'] = [];
}

if (!isset($_SESSION['invitation'])) {
    $_SESSION['invitation'] = [];
}

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/invitation/establisment-ch-register-form.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';