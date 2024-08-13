<?php
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
session_start();
$titrePage = "motiV";


if (!isset($_SESSION['establishment_id'])) {
    header('Location: /ctrl/professor/register-form.php');
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/professor/registration-form.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';