<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/city-hall.php';

$dbConnection = getConnection($dbConfig);
$titrePage = "motiV";

$id = $_GET['id'];
$cityHall = getCityHallById($id, $dbConnection);

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/city-hall/update-display.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';