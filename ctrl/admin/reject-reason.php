<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/verification.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/partner.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/association.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = htmlspecialchars($_POST['type']);
    $id = htmlspecialchars($_POST['id']);
    $reason = htmlspecialchars($_POST['reason']);
    $status = 'rejected';

    $dbConnection = getConnection($dbConfig);

    if ($type == 'association') {
        updateAssociationStatus($id, $status, $dbConnection);
        $association = getAssociationById($id, $dbConnection);
        sendMessage($association['idUser'], 'Rejet de votre association', $reason, $dbConnection);
        addRejectionReason($id, $type, $reason, $dbConnection);
        deleteAssociation($id, $dbConnection); // Suppression de l'association après rejet
    } elseif ($type == 'partner') {
        updatePartnerStatus($id, $status, $dbConnection);
        $partner = getPartnerById($id, $dbConnection);
        sendMessage($partner['idUser'], 'Rejet de votre entreprise', $reason, $dbConnection);
        addRejectionReason($id, $type, $reason, $dbConnection);
        deletePartner($id, $dbConnection); // Suppression du partenaire après rejet
    }

    header('Location: /ctrl/admin/profile.php');
    exit();
}