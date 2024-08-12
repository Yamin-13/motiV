<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/educational-establishment.php';

$id = $_GET['id'];
$dbConnection = getConnection($dbConfig);
$educationalEstablishment = getEducationalEstablishmentById($id, $dbConnection);

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/educational-establishment/update-display.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';