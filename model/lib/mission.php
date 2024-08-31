<?php

// permet de créer une nouvelle mission
function createMission($title, $description, $pointsPerHour, $startDate, $endDate, $imageFilename, $numberOfPlaces, $idUser, $idAssociation, $dbConnection)
{
    $query = "INSERT INTO mission (title, description, point_award, start_date_mission, end_date_mission, image_filename, number_of_places, idUser, idAssociation) 
              VALUES (:title, :description, :point_award, :start_date_mission, :end_date_mission, :image_filename, :number_of_places, :idUser, :idAssociation)";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':title', $title);
    $statement->bindParam(':description', $description);
    $statement->bindParam(':point_award', $pointsPerHour);
    $statement->bindParam(':start_date_mission', $startDate);
    $statement->bindParam(':end_date_mission', $endDate);
    $statement->bindParam(':image_filename', $imageFilename);
    $statement->bindParam(':number_of_places', $numberOfPlaces);
    $statement->bindParam(':idUser', $idUser);
    $statement->bindParam(':idAssociation', $idAssociation);
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
        return false; // Le jeune est déjà inscrit à cette mission
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

        // Met à jour le statut de la mission si le nombre de places atteint zéro
        if ($mission['number_of_places'] - 1 == 0) {
            $query = "UPDATE mission SET status = 'complete' WHERE id = :idMission";
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':idMission', $idMission, PDO::PARAM_INT);
            $statement->execute();
        }

        // Inscrit le jeune à la mission
        $query = "INSERT INTO mission_registration (idMission, idUser) VALUES (:idMission, :idUser)";
        $statement = $dbConnection->prepare($query);
        $statement->bindParam(':idMission', $idMission, PDO::PARAM_INT);
        $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
        $statement->execute();

        return true;
    } else {
        return false; // Pas de place disponible
    }
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

    // Récupére les utilisateurs inscrits à la mission
    $query = "SELECT idUser FROM mission_registration WHERE idMission = :idMission AND status = 'registered'";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $idMission);
    $statement->execute();
    $registeredUsers = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Récupére la mission pour calculer les points
    $query = "SELECT point_award, start_date_mission, end_date_mission FROM mission WHERE id = :idMission";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $idMission);
    $statement->execute();
    $mission = $statement->fetch(PDO::FETCH_ASSOC);

    $missionHours = (strtotime($mission['end_date_mission']) - strtotime($mission['start_date_mission'])) / 3600;
    $totalPoints = $missionHours * $mission['point_award'];

    // Attribue les points aux utilisateurs
    foreach ($registeredUsers as $user) {
        awardPoints($user['idUser'], $totalPoints, 'Mission accomplie', $dbConnection);

        // Marque la mission comme complétée pour chaque utilisateur
        $query = "UPDATE mission_registration SET status = 'completed' WHERE idMission = :idMission AND idUser = :idUser";
        $statement = $dbConnection->prepare($query);
        $statement->bindParam(':idMission', $idMission);
        $statement->bindParam(':idUser', $user['idUser']);
        $statement->execute();
    }
}

function getAllMissions($dbConnection)
{
    $query = "SELECT m.id, m.title, m.description, m.point_award, m.start_date_mission, m.end_date_mission, m.number_of_places, m.status, a.name AS association_name 
              FROM mission m 
              JOIN association a ON m.idAssociation = a.id 
              WHERE m.status != 'accomplished' 
              ORDER BY m.start_date_mission DESC";
    $statement = $dbConnection->prepare($query);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getRegisteredUsersByMission($idMission, $dbConnection)
{
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
    $query = "SELECT id, title, description, point_award, start_date_mission, end_date_mission, number_of_places, status, image_filename 
              FROM mission 
              WHERE id = :idMission";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $idMission, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function deleteMission($idMission, $dbConnection)
{
    $query = "DELETE FROM mission WHERE id = :idMission";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $idMission, PDO::PARAM_INT);
    return $statement->execute();
}

function getMissionsByAssociation($idAssociation, $dbConnection)
{
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
    $missionHours = (strtotime($endDate) - strtotime($startDate)) / 3600;
    return $missionHours;
}

// permet de marquer un utilisateur comme absent pour une mission... 
// ... elle met à jour l'inscription avec un statut "canceled" ...
// ... et peut enregistrer une raison pour l'absence
function markAsAbsent($idMission, $idUser, $reason, $dbConnection)
{
    $query = "UPDATE mission_registration SET status = 'canceled', marked_absent = 1, cancellation_reason = :reason WHERE idMission = :idMission AND idUser = :idUser";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $idMission);
    $statement->bindParam(':idUser', $idUser);
    $statement->bindParam(':reason', $reason);
    $statement->execute();
}

function getAssociationIdByMissionId($idMission, $dbConnection)
{
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

function unregisterFromMission($idMission, $idUser, $dbConnection)
{
    // Supprime l'inscription du jeune à la mission
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

        // Met à jour le statut de la mission si le nombre de places redevient supérieur à zéro
        $query = "UPDATE mission SET status = 'open' WHERE id = :idMission AND number_of_places > 0";
        $statement = $dbConnection->prepare($query);
        $statement->bindParam(':idMission', $idMission, PDO::PARAM_INT);
        $statement->execute();

        return true;
    } else {
        return false;
    }
}

function isUserRegisteredForMission($idUser, $idMission, $dbConnection)
{
    $query = "SELECT COUNT(id) FROM mission_registration WHERE idMission = :idMission AND idUser = :idUser";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $idMission, PDO::PARAM_INT);
    $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchColumn() > 0;
}

function getCompleteMissionsByAssociation($idAssociation, $dbConnection)
{
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
    $query = "SELECT m.id, m.title, m.start_date_mission, a.name AS association_name,
            (SELECT COUNT(idUser) FROM mission_registration WHERE idMission = m.id AND status = 'registered') AS num_participants
            FROM mission m
            JOIN association a ON m.idAssociation = a.id
            WHERE m.status = 'open' OR m.status = 'complete'
            ORDER BY a.name, m.start_date_mission";
    $statement = $dbConnection->prepare($query);
    $statement->execute();
    $missions = $statement->fetchAll(PDO::FETCH_ASSOC);

    $groupedMissions = [];
    foreach ($missions as $mission) {
        $groupedMissions[$mission['association_name']][] = $mission;
    }

    return $groupedMissions;
}

function getAllCompletedMissions($dbConnection)
{
    $query = "SELECT m.id, m.title, m.start_date_mission, a.name AS association_name,
            (SELECT COUNT(idUser) FROM mission_registration WHERE idMission = m.id AND status = 'registered') AS num_participants
            FROM mission m
            JOIN association a ON m.idAssociation = a.id
            WHERE m.status = 'accomplished'
            ORDER BY a.name, m.start_date_mission";
    $statement = $dbConnection->prepare($query);
    $statement->execute();
    $missions = $statement->fetchAll(PDO::FETCH_ASSOC);

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
