<?php

// permet de créer une nouvelle mission
function createMission($title, $description, $pointsPerHour, $startDate, $endDate, $imageFilename, $numberOfPlaces, $idUser, $idAssociation, $dbConnection)
{
    // Prépare la requête pour insérer une mission dans la base de données
    $query = "INSERT INTO mission (title, description, point_award, start_date_mission, end_date_mission, image_filename, number_of_places, idUser, idAssociation) 
              VALUES (:title, :description, :point_award, :start_date_mission, :end_date_mission, :image_filename, :number_of_places, :idUser, :idAssociation)";
    $statement = $dbConnection->prepare($query);
    // Lie les paramètres aux valeurs fournies
    $statement->bindParam(':title', $title);
    $statement->bindParam(':description', $description);
    $statement->bindParam(':point_award', $pointsPerHour);
    $statement->bindParam(':start_date_mission', $startDate);
    $statement->bindParam(':end_date_mission', $endDate);
    $statement->bindParam(':image_filename', $imageFilename);
    $statement->bindParam(':number_of_places', $numberOfPlaces);
    $statement->bindParam(':idUser', $idUser);
    $statement->bindParam(':idAssociation', $idAssociation);
    // Exécute la requête pour ajouter la mission
    return $statement->execute();
}

// permet à un utilisateur de s'inscrire à une mission si des places...
// ... sont encore disponibles
function registerForMission($idMission, $idUser, $dbConnection)
{
    // Vérifie si l'utilisateur est déjà inscrit à cette mission
    $query = "SELECT idUser FROM mission_registration WHERE idMission = :idMission AND idUser = :idUser";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $idMission, PDO::PARAM_INT);
    $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    $statement->execute();
    $alreadyRegistered = $statement->fetch(PDO::FETCH_ASSOC);

    if ($alreadyRegistered) {
        return false; // L'utilisateur est déjà inscrit
    }

    // Vérifie si la mission a encore des places disponibles
    $query = "SELECT number_of_places FROM mission WHERE id = :idMission FOR UPDATE";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $idMission, PDO::PARAM_INT);
    $statement->execute();
    $mission = $statement->fetch(PDO::FETCH_ASSOC);

    if ($mission['number_of_places'] > 0) {
        // Diminue le nombre de places disponibles
        $query = "UPDATE mission SET number_of_places = number_of_places - 1 WHERE id = :idMission";
        $statement = $dbConnection->prepare($query);
        $statement->bindParam(':idMission', $idMission, PDO::PARAM_INT);
        $statement->execute();

        // Met à jour le statut de la mission si elle est complète
        if ($mission['number_of_places'] - 1 == 0) {
            $query = "UPDATE mission SET status = 'complete' WHERE id = :idMission";
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':idMission', $idMission, PDO::PARAM_INT);
            $statement->execute();
        }

        // Inscrit l'utilisateur à la mission
        $query = "INSERT INTO mission_registration (idMission, idUser) VALUES (:idMission, :idUser)";
        $statement = $dbConnection->prepare($query);
        $statement->bindParam(':idMission', $idMission, PDO::PARAM_INT);
        $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
        $statement->execute();

        return true;
    }
    return false; // Pas de place disponible
}

// marque une mission comme accomplie, calcule les points à attribuer.... 
// ...en fonction de la durée de la mission, et distribue les points aux utilisateurs inscrits...
// ... elle met également à jour le statut des inscriptions à "completed"
function validateMission($idMission, $dbConnection)
{
    // Marque la mission comme accomplie
    $query = "UPDATE mission SET status = 'accomplished' WHERE id = :idMission";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $idMission);
    $statement->execute();

    // Récupère les utilisateurs inscrits à la mission
    $query = "SELECT idUser FROM mission_registration WHERE idMission = :idMission AND status = 'registered'";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $idMission);
    $statement->execute();
    $registeredUsers = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Récupère les détails de la mission pour calculer les points
    $query = "SELECT point_award, start_date_mission, end_date_mission FROM mission WHERE id = :idMission";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $idMission);
    $statement->execute();
    $mission = $statement->fetch(PDO::FETCH_ASSOC);

    // Calcule la durée de la mission en heures
    $missionHours = (strtotime($mission['end_date_mission']) - strtotime($mission['start_date_mission'])) / 3600;
    // Calcule le total de points à attribuer
    $totalPoints = $missionHours * $mission['point_award'];

    // Attribue les points à chaque utilisateur inscrit
    foreach ($registeredUsers as $user) {
        awardPoints($user['idUser'], $totalPoints, 'Mission accomplie', $dbConnection);

        // Met à jour le statut de l'inscription de l'utilisateur
        $query = "UPDATE mission_registration SET status = 'completed' WHERE idMission = :idMission AND idUser = :idUser";
        $statement = $dbConnection->prepare($query);
        $statement->bindParam(':idMission', $idMission);
        $statement->bindParam(':idUser', $user['idUser']);
        $statement->execute();
    }
}

function getAllMissions($dbConnection)
{
    // Récupère toutes les missions avec les informations de l'association
    $query = "SELECT m.id, m.title, m.description, m.start_date_mission, m.end_date_mission, m.number_of_places, 
                     m.point_award, m.image_filename, m.idUser, a.name AS association_name
              FROM mission m
              JOIN association a ON m.idAssociation = a.id
              ORDER BY m.start_date_mission DESC";
    $statement = $dbConnection->prepare($query);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function updateMission($idMission, $title, $description, $start_date, $start_time, $end_date, $end_time, $number_of_places, $image_filename, $dbConnection)
{
    // Combine la date et l'heure de début et de fin
    $start_date_time = DateTime::createFromFormat('Y-m-d H:i', "$start_date $start_time")->format('Y-m-d H:i:s');
    $end_date_time = DateTime::createFromFormat('Y-m-d H:i', "$end_date $end_time")->format('Y-m-d H:i:s');

    // Met à jour les informations de la mission
    $query = "UPDATE mission 
              SET title = :title, description = :description, start_date_mission = :start_date_time, 
                  end_date_mission = :end_date_time, number_of_places = :number_of_places, image_filename = :image_filename 
              WHERE id = :idMission";

    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':title', $title);
    $statement->bindParam(':description', $description);
    $statement->bindParam(':start_date_time', $start_date_time);
    $statement->bindParam(':end_date_time', $end_date_time);
    $statement->bindParam(':number_of_places', $number_of_places, PDO::PARAM_INT);
    $statement->bindParam(':image_filename', $image_filename);
    $statement->bindParam(':idMission', $idMission, PDO::PARAM_INT);

    return $statement->execute();
}

function getRegisteredUsersByMission($idMission, $dbConnection)
{
    // Récupère les utilisateurs inscrits à une mission
    $query = "SELECT mr.idUser, u.first_name, u.name, u.email 
              FROM mission_registration mr
              JOIN user u ON mr.idUser = u.id
              WHERE mr.idMission = :idMission AND mr.status = 'registered'";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $idMission, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getMissionById($idMission, $dbConnection)
{
    // Récupère les détails d'une mission spécifique
    $query = "SELECT m.id, m.title, m.description, m.point_award, m.start_date_mission, m.end_date_mission, m.number_of_places, m.status, m.image_filename, m.idAssociation, a.name AS association_name
              FROM mission m
              JOIN association a ON m.idAssociation = a.id
              WHERE m.id = :idMission";

    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $idMission, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function deleteMission($idMission, $dbConnection)
{
    // Supprime une mission de la base de données
    $query = "DELETE FROM mission WHERE id = :idMission";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $idMission, PDO::PARAM_INT);
    return $statement->execute();
}

function getMissionsByAssociation($idAssociation, $dbConnection)
{
    // Récupère les missions non accomplies d'une association
    $query = "SELECT id, title, description, point_award, start_date_mission, end_date_mission, image_filename, number_of_places, status 
              FROM mission 
              WHERE idAssociation = :idAssociation AND status != 'accomplished' 
              ORDER BY start_date_mission DESC";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idAssociation', $idAssociation, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function calculatePointsForMission($startDate, $endDate)
{
    // Calcule le nombre d'heures entre deux dates
    $missionHours = (strtotime($endDate) - strtotime($startDate)) / 3600;
    return $missionHours;
}

// permet de marquer un utilisateur comme absent pour une mission... 
// ... elle met à jour l'inscription avec un statut "canceled" ...
// ... et peut enregistrer une raison pour l'absence
function markAsAbsent($idMission, $idUser, $reason, $dbConnection)
{
    // Met à jour le statut de l'inscription de l'utilisateur
    $query = "UPDATE mission_registration SET status = 'canceled', marked_absent = 1, cancellation_reason = :reason WHERE idMission = :idMission AND idUser = :idUser";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $idMission);
    $statement->bindParam(':idUser', $idUser);
    $statement->bindParam(':reason', $reason);
    $statement->execute();
}

function getAssociationIdByMissionId($idMission, $dbConnection)
{
    // Récupère l'ID de l'association liée à une mission
    $query = "SELECT idAssociation FROM mission WHERE id = :idMission";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $idMission, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchColumn();
}

// récupère les missions que l'utilisateur a acceptées...
//...elle fait une jointure entre la table mission_registration... 
//...(qui relie les utilisateurs aux missions) et la table mission...
//... pour obtenir les détails des missions que l'utilisateur a acceptées (status = 'registered')
function getAcceptedMissionsByUser($idUser, $dbConnection)
{
    // Récupère les missions acceptées par un utilisateur
    $query = "SELECT m.id, m.title, m.start_date_mission, m.end_date_mission
              FROM mission m
              JOIN mission_registration mr ON m.id = mr.idMission
              WHERE mr.idUser = :idUser AND mr.status = 'registered'";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getMissionDetailsWithRegistrations($idMission, $dbConnection)
{
    // Récupère les détails d'une mission avec les inscriptions
    $query = "SELECT m.id, m.title, m.description, m.point_award, m.start_date_mission, m.end_date_mission, m.number_of_places, m.status, m.image_filename,
                     COALESCE(u.id, '') as user_id, u.first_name, u.name, u.email
              FROM mission m
              LEFT JOIN mission_registration mr ON m.id = mr.idMission
              LEFT JOIN user u ON mr.idUser = u.id
              WHERE m.id = :idMission";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $idMission, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
/**  */
function unregisterFromMission(string $idMission, string $idUser, \PDO $dbConnection): bool
{
    // Supprime l'inscription de l'utilisateur à la mission
    $query = "DELETE FROM mission_registration WHERE idMission = :idMission AND idUser = :idUser";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $idMission, PDO::PARAM_INT);
    $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    $statement->execute();

    if ($statement->rowCount() > 0) {

        // Augmente le nombre de places disponibles
        $query = "UPDATE mission SET number_of_places = number_of_places + 1 WHERE id = :idMission";
        $statement = $dbConnection->prepare($query);
        $statement->bindParam(':idMission', $idMission, PDO::PARAM_INT);
        $statement->execute();

        // Met à jour le statut de la mission si nécessaire
        $query = "UPDATE mission SET status = 'open' WHERE id = :idMission AND number_of_places > 0";
        $statement = $dbConnection->prepare($query);
        $statement->bindParam(':idMission', $idMission, PDO::PARAM_INT);
        $statement->execute();

        return true;
    }
    return false;
}

function isUserRegisteredForMission($idUser, $idMission, $dbConnection)
{
    // Vérifie si un utilisateur est inscrit à une mission
    $query = "SELECT COUNT(id) FROM mission_registration WHERE idMission = :idMission AND idUser = :idUser";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $idMission, PDO::PARAM_INT);
    $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchColumn() > 0;
}

function getCompleteMissionsByAssociation($idAssociation, $dbConnection)
{
    // Récupère les missions complètes d'une association
    $query = "SELECT id, title, description, point_award, start_date_mission, end_date_mission, image_filename, number_of_places, status 
              FROM mission 
              WHERE idAssociation = :idAssociation AND status = 'complete' 
              ORDER BY start_date_mission DESC";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idAssociation', $idAssociation);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getAccomplishedMissionsByAssociation($idAssociation, $dbConnection)
{
    // Récupère les missions accomplies d'une association
    $query = "SELECT id, title, description, point_award, start_date_mission, end_date_mission, image_filename 
              FROM mission 
              WHERE idAssociation = :idAssociation AND status = 'accomplished' 
              ORDER BY start_date_mission DESC";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idAssociation', $idAssociation, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getMissionParticipants($idMission, $dbConnection)
{
    // Récupère les participants d'une mission
    $query = "SELECT u.first_name, u.name, u.email, mr.status 
              FROM mission_registration mr
              JOIN user u ON mr.idUser = u.id
              WHERE mr.idMission = :idMission";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $idMission, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getAllOngoingMissions($dbConnection)
{
    // Récupère toutes les missions en cours
    $query = "SELECT m.id, m.title, m.start_date_mission, a.name AS association_name,
            (SELECT COUNT(idUser) FROM mission_registration WHERE idMission = m.id AND status = 'registered') AS num_participants
            FROM mission m
            JOIN association a ON m.idAssociation = a.id
            WHERE m.status = 'open' OR m.status = 'complete'
            ORDER BY a.name, m.start_date_mission";
    $statement = $dbConnection->prepare($query);
    $statement->execute();
    $missions = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Regroupe les missions par association
    $groupedMissions = [];
    foreach ($missions as $mission) {
        $groupedMissions[$mission['association_name']][] = $mission;
    }

    return $groupedMissions;
}

function getAllCompletedMissions($dbConnection)
{
    // Récupère toutes les missions accomplies
    $query = "SELECT m.id, m.title, m.start_date_mission, a.name AS association_name,
            (SELECT COUNT(idUser) FROM mission_registration WHERE idMission = m.id AND status = 'registered') AS num_participants
            FROM mission m
            JOIN association a ON m.idAssociation = a.id
            WHERE m.status = 'accomplished'
            ORDER BY a.name, m.start_date_mission";
    $statement = $dbConnection->prepare($query);
    $statement->execute();
    $missions = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Ajoute les participants à chaque mission
    $groupedMissions = [];
    foreach ($missions as $mission) {
        $participants = getMissionParticipants($mission['id'], $dbConnection);
        $mission['participants'] = $participants;
        $groupedMissions[$mission['association_name']][] = $mission;
    }

    return $groupedMissions;
}

function getParticipantsByAssociation($idAssociation, $dbConnection)
{
    // Récupère les participants pour toutes les missions d'une association
    $query = "SELECT u.first_name, u.name, u.email, m.title AS mission_title, mr.status, m.start_date_mission
            FROM  mission_registration mr
            JOIN user u ON mr.idUser = u.id
            JOIN mission m ON mr.idMission = m.id
            WHERE m.idAssociation = :idAssociation
            ORDER BY m.start_date_mission DESC";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idAssociation', $idAssociation, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getCompletedMissionsByUser($idUser, $dbConnection)
{
    // Récupère les missions complétées par un utilisateur
    $query = "SELECT m.id, m.title, m.description, m.point_award, m.start_date_mission, m.end_date_mission 
              FROM mission m
              JOIN mission_registration mr ON m.id = mr.idMission
              WHERE mr.idUser = :idUser AND mr.status = 'completed'
              ORDER BY m.end_date_mission DESC";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getLatestMissions($dbConnection, $limit = 5)
{
    // Récupère les dernières missions disponibles
    $query = "SELECT id, title, point_award, start_date_mission, end_date_mission, number_of_places, image_filename
              FROM mission
              WHERE end_date_mission > NOW() -- exclut les missions expirées
              AND number_of_places > 0 -- exclut les missions sans places dispo
              ORDER BY start_date_mission DESC
              LIMIT :limit";

    $statement = $dbConnection->prepare($query);
    $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

// Marque la mission comme accomplie
function markMissionAsAccomplished($missionId, $dbConnection) {
    $query = "UPDATE mission SET status = 'accomplished' WHERE id = :idMission";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $missionId, PDO::PARAM_INT);
    $statement->execute();
}

// Marque la mission comme accomplie pour un utilisateur et attribue des points
function completeMissionForUser($missionId, $userId, $points, $dbConnection) {
    $query = "UPDATE mission_registration SET status = 'completed' 
              WHERE idMission = :idMission AND idUser = :idUser";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $missionId, PDO::PARAM_INT);
    $statement->bindParam(':idUser', $userId, PDO::PARAM_INT);
    $statement->execute();

    // Attribue les points au jeune
    awardPoints($userId, $points, 'Mission accomplie', $dbConnection);

    // Envoie un message au jeune
    sendMessage($userId, 'Mission accomplie', 'Vous avez reçu ' . $points . ' points pour avoir complété la mission.', $dbConnection);
}

// Marque la mission comme annulée pour un utilisateur et retire des points
function cancelMissionForUser($missionId, $userId, $dbConnection) {
    $query = "UPDATE mission_registration SET status = 'canceled', marked_absent = 1 
              WHERE idMission = :idMission AND idUser = :idUser";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $missionId, PDO::PARAM_INT);
    $statement->bindParam(':idUser', $userId, PDO::PARAM_INT);
    $statement->execute();

    // Retire 50 points sans descendre en dessous de 0
    $pointsToRemove = min(50, getUserPoints($userId, $dbConnection));
    awardPoints($userId, -$pointsToRemove, 'Absence à la mission', $dbConnection);

    // Envoie un message au jeune
    sendMessage($userId, 'Absence à la mission', 'Vous avez perdu ' . $pointsToRemove . ' points pour absence à la mission.', $dbConnection);
}
