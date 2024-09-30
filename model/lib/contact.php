<?php
// Fonction pour envoyer un message depuis un utilisateur vers l'admin
function sendContactMessageToAdmin($userId, $subject, $body, $dbConnection)
{
    $query = "INSERT INTO contact_message (idUser, subject, body) 
              VALUES (:idUser, :subject, :body)";

    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idUser', $userId);
    $statement->bindParam(':subject', $subject);
    $statement->bindParam(':body', $body);

    // Execute la requête
    return $statement->execute();
}

// Fonction pour récupérer tous les messages destinés à l'admin
function getMessagesForAdmin($dbConnection)
{
    // prépare une requête SQL qui va sélectionner des information dans la BDD
    $query = "SELECT cm.id, cm.subject, cm.body, cm.sent_at, u.first_name, u.name, u.idRole,
    
        -- Le mot CASE commence une condition qui va renvoyé une valeur en fonction du rôle de l'utilisateur (idRole).
        CASE 
            -- si le role de l'utilisateur est 50 ou 55 (membre ou admin d'une association) ca récupère le nom de l'association
            WHEN u.idRole IN (50, 55) THEN (
                SELECT a.name FROM association a WHERE a.idUser = u.id
            )
            WHEN u.idRole IN (30, 35) THEN (
                SELECT ch.name FROM city_hall_user chu JOIN city_hall ch ON chu.idCityHall = ch.id WHERE chu.idUser = u.id LIMIT 1
            )
            WHEN u.idRole IN (40, 45) THEN (
                SELECT p.name FROM partner_user pu JOIN partner p ON pu.idPartner = p.id WHERE pu.idUser = u.id LIMIT 1
            )
            WHEN u.idRole IN (20, 25, 27) THEN (
                SELECT ee.name FROM educational_establishment_user eeu JOIN educational_establishment ee ON eeu.idEducationalEstablishment = ee.id WHERE eeu.idUser = u.id LIMIT 1
            )
            -- Si le rôle de l'utilisateur est 60 (jeune) ca renvoie simplement Jeune comme nom d'entité
            WHEN u.idRole = 60 THEN 'Jeune'
            -- Si le rôle ne correspond à aucune de ces valeur ca renvoie Inconnu
            ELSE 'Inconnu'
        -- END marque la fin de la condition CASE et AS permet de donner un nom à cette colonne ici entity_name
        END AS entity_name,

        -- nouvelle condition CASE pour récupérer le type de l'entité en français
        CASE 
            -- si le rôle de l'utilisateur est 50 ou 55 c'est une asso
            WHEN u.idRole IN (50, 55) THEN 'Association'
            WHEN u.idRole IN (30, 35) THEN 'Mairie'
            WHEN u.idRole IN (40, 45) THEN 'Partenaire'
            WHEN u.idRole IN (20, 25, 27) THEN 'Établissement scolaire'
            -- si le rôle de l'utilisateur est 60 c'est un Jeune
            WHEN u.idRole = 60 THEN 'Jeune'
            -- si rien ne correspond c'est Inconnu
            ELSE 'Inconnu'
        -- END termine cette seconde condition CASE et AS donne à cette colonne le nom entity_type
        END AS entity_type

    -- FROM indique de quelles tables on tire les donnée là on prend les messages de la table contact_message (alias cm)
    FROM contact_message cm
    -- JOIN signifie qu'on associe la table user à contact_message via l'id de l'utilisateur pour obtenir les infos de chaque utilisateur
    JOIN user u ON cm.idUser = u.id
    -- ORDER BY permet de trier les messages par date d'envoi (colonne sent_at) du plus récent au plus ancien (DESC = descendant)
    ORDER BY cm.sent_at DESC";

    // ca prépare la requête SQL avant de l'exécuter ca permet de sécurisé les données en évitant certaines attaques
    $statement = $dbConnection->prepare($query);
    // exécute la requête on envoie cette requête SQL à la BDD pour qu'elle nous renvoie les résultats
    $statement->execute();

    // On récupère tous les résultat sous forme de tableau associatif (clé/valeur) c'est ce que retourne la fonction
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour ajouter une réponse de l'admin à un message utilisateur
function replyToContactMessage($messageId, $response, $dbConnection)
{
    $query = "UPDATE contact_message 
              SET admin_response = :admin_response, response_at = NOW() 
              WHERE id = :message_id";

    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':admin_response', $response);
    $statement->bindParam(':message_id', $messageId);

    // Exécuter la mise à jour
    return $statement->execute();
}

// Fonction pour récupérer les messages envoyé par un utilisateur avec la réponse de l'admin
function getContactMessagesByUser($idUser, $dbConnection)
{
    $query = "SELECT subject, body, admin_response, sent_at, response_at 
              FROM contact_message 
              WHERE idUser = :idUser 
              ORDER BY sent_at DESC";

    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idUser', $idUser);
    $statement->execute();

    // Retourne les message de l'utilisateur
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
