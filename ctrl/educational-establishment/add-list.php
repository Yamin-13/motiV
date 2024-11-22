<?php
session_start();
$titrePage = "Ajouter un Etablissement Scolaire | MotiV – La plateforme qui valorise l'effort";

$idRole = $_SESSION['user']['idRole'];
if ($idRole == [20, 25]){
    include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/view/educational-establishment.php/add-list.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';
} else {
    // rend la vue
    header('Location: /ctrl/login/login-display.php');
}