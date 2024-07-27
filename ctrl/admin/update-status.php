<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/verification.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = htmlspecialchars($_POST['type']);
    $id = htmlspecialchars($_POST['id']);
    $action = htmlspecialchars($_POST['action']);
    $status = ($action == 'approve') ? 'approved' : 'rejected';

    $dbConnection = getConnection($dbConfig);

    if ($type == 'association') {
        updateAssociationStatus($id, $status, $dbConnection);
        if ($action == 'reject') {
            deleteAssociation($id, $dbConnection);
        }
    } elseif ($type == 'partner') {
        updatePartnerStatus($id, $status, $dbConnection);
        if ($action == 'reject') {
            deletePartner($id, $dbConnection);
        }
    }

    header('Location: /ctrl/admin/profile.php');
    exit();
}
