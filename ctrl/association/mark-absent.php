<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';

$idMission = $_POST['idMission'];
$idUser = $_POST['idUser'];
$reason = $_POST['reason'];

$dbConnection = getConnection($dbConfig);

markAsAbsent($idMission, $idUser, $reason, $dbConnection);

$_SESSION['success'] = "Le jeune a été marqué comme absent.";
header('Location: /ctrl/association/mission-details.php?id=' . $idMission);
exit();