<?php
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
session_start();
$titrePage = "Eregistrement du Professeur | MotiV – La plateforme qui valorise l'effort";

if (!isset($_SESSION['establishment_id'])) {
    header('Location: /ctrl/professor/register-form.php');
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/professor/registration-form.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';