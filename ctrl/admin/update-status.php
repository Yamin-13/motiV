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
            $_SESSION['message'] = "L'association a été rejetée et supprimée.";
        } else {
            $_SESSION['message'] = "L'association a été acceptée.";
        }
    } elseif ($type == 'partner') {
        updatePartnerStatus($id, $status, $dbConnection);
        if ($action == 'reject') {
            deletePartner($id, $dbConnection);
            $_SESSION['message'] = "Le partenaire a été rejeté et supprimé.";
        } else {
            $_SESSION['message'] = "Le partenaire a été accepté.";
        }
    }

    header('Location: /ctrl/admin/profile.php');
    exit();
}