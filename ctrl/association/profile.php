<?php
session_start();
$titrePage = "motiV";

$idRole = $_SESSION['user']['idRole'];
if ($idRole == 50){
    include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/view/city-hall/profile.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';
} else {
    // rend la vue
    header('Location: /ctrl/login/login-display.php');
}