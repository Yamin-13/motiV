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
    // Vérifie si la mission a encore des place
    $query = "SELECT COUNT(id) as registered_count FROM mission_registration WHERE idMission = :idMission AND status = 'registered'";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $idMission);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    // Récupére le nombre de place disponible pour la mission
    $query = "SELECT number_of_places FROM mission WHERE id = :idMission";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $idMission);
    $statement->execute();
    $mission = $statement->fetch(PDO::FETCH_ASSOC);

    if ($result['registered_count'] < $mission['number_of_places']) {
        // Inscrit le jeune
        $query = "INSERT INTO mission_registration (idMission, idUser) VALUES (:idMission, :idUser)";
        $statement = $dbConnection->prepare($query);
        $statement->bindParam(':idMission', $idMission);
        $statement->bindParam(':idUser', $idUser);
        $statement->execute();

        // Vérifie si la mission est complète
        if ($result['registered_count'] + 1 == $mission['number_of_places']) {
            // Marque la mission comme complète
            $query = "UPDATE mission SET status = 'complete' WHERE id = :idMission";
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':idMission', $idMission);
            $statement->execute();
        }
        return true;
    } else {
        return false; // pas de place disponible
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
    $query = "SELECT m.id, m.title, m.description, m.point_award, m.start_date_mission, m.end_date_mission, m.number_of_places, a.name AS association_name 
              FROM mission m 
              JOIN association a ON m.idAssociation = a.id 
              WHERE m.status != 'completed' 
              ORDER BY m.start_date_mission DESC";
    $statement = $dbConnection->prepare($query);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}


function getRegisteredUsersByMission($idMission, $dbConnection)
{
    $query = "SELECT idUser FROM mission_registration WHERE idMission = :idMission AND status = 'registered'";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $idMission);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getMissionById($idMission, $dbConnection)
{
    $query = "SELECT title, description, point_award, start_date_mission, end_date_mission, number_of_places, status, image_filename 
              FROM mission 
              WHERE id = :idMission";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $idMission, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function deleteMission($idMission, $dbConnection) {
    $query = "DELETE FROM mission WHERE id = :idMission";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $idMission, PDO::PARAM_INT);
    return $statement->execute();
}

function getMissionsByAssociation($idAssociation, $dbConnection)
{
    $query = "SELECT id, title, description, point_award, start_date_mission, end_date_mission, image_filename, number_of_places, status 
              FROM mission 
              WHERE idAssociation = :idAssociation 
              ORDER BY start_date_mission DESC";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idAssociation', $idAssociation);
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

function getAssociationIdByMissionId($idMission, $dbConnection) {
    $query = "SELECT idAssociation FROM mission WHERE id = :idMission";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idMission', $idMission, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchColumn();
}
