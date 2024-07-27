<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/verification.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = htmlspecialchars($_POST['type']);
    $id = htmlspecialchars($_POST['id']);
    $reason = htmlspecialchars($_POST['reason']);
    $status = 'rejected';

    $dbConnection = getConnection($dbConfig);

    if ($type == 'association') {
        updateAssociationStatus($id, $status, $dbConnection);
    } elseif ($type == 'partner') {
        updatePartnerStatus($id, $status, $dbConnection);
    }

    addRejectionReason($id, $type, $reason, $dbConnection);

    header('Location: /ctrl/admin/profile.php');
    exit();
}

function addRejectionReason($entityId, $entityType, $reason, $dbConnection) {
    $stmt = $dbConnection->prepare("INSERT INTO rejections (entity_id, entity_type, reason) VALUES (:entity_id, :entity_type, :reason)");
    $stmt->bindParam(':entity_id', $entityId);
    $stmt->bindParam(':entity_type', $entityType);
    $stmt->bindParam(':reason', $reason);
    $stmt->execute();
}
