<?php
session_start(); // ca initialise une session et permet à $_SESSION de fonctionner (de stocker dans les coockies) 

$titrePage = "motiV";

// rend la vue
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/login/register-display.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';
