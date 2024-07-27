<?php

function getPendingPartners($dbConnection) {
    $stmt = $dbConnection->prepare("SELECT id, name, address, siret_number, image_filename, idUser, status FROM partner WHERE status = 'pending'");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getPendingAssociations($dbConnection) {
    $stmt = $dbConnection->prepare("SELECT id, name, email, description, phone_number, address, RNE_number, image_filename, idUser, status FROM association WHERE status = 'pending'");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updatePartnerStatus($id, $status, $dbConnection) {
    $stmt = $dbConnection->prepare("UPDATE partner SET status = :status WHERE id = :id");
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

function updateAssociationStatus($id, $status, $dbConnection) {
    $stmt = $dbConnection->prepare("UPDATE association SET status = :status WHERE id = :id");
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

function deleteAssociation($id, $dbConnection) {
    $stmt = $dbConnection->prepare("DELETE FROM association WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

function deletePartner($id, $dbConnection) {
    $stmt = $dbConnection->prepare("DELETE FROM partner WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

function getRejectionReason($entityId, $entityType, $dbConnection) {
    $stmt = $dbConnection->prepare("SELECT reason FROM rejections WHERE entity_id = :entity_id AND entity_type = :entity_type");
    $stmt->bindParam(':entity_id', $entityId);
    $stmt->bindParam(':entity_type', $entityType);
    $stmt->execute();
    return $stmt->fetchColumn();
}

