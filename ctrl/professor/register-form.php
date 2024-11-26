<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';

$titrePage = "Inscription du professeur | MotiV – La plateforme qui valorise l'effort";

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/professor/register-form.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php'; 