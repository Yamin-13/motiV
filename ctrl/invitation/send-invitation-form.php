<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/association.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/partner.php';

$dbConnection = getConnection($dbConfig);

$user = $_SESSION['user'];
$association = getAssociationByidUser($user['id'], $dbConnection);
$partner = getPartnerByidUser($user['id'], $dbConnection);

$entityType = $association ? 'association' : 'partner';
$entityId = $association ? $association['id'] : $partner['id'];

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/invitation/send-invitation-form.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';