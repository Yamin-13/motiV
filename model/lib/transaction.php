<?php

function getAllTransactions($dbConnection)
{

    $query = "SELECT r.id, r.title, -- récupère l'ID et le titre de chaque récompense
    --  On veut le nom de celui qui a soumis la récompense...
    -- ...si c'est une mairie on prend son nom (ch.name)... 
    -- ...sinon on prend le nom du partenaire (p.name)...
    -- ...COALESCE choisit le premier qui n'est pas vide (null)
               COALESCE(ch.name, p.name) AS submitter_name, 
    -- ca compte combien de fois cette récompense a été achetée
               COUNT(t.id) AS total_purchases, r.quantity_available
        FROM transaction t
    -- ca fait une jointure entre les transactions et les récompenses...
    -- ... pour savoir quelle transaction correspond à quelle récompense
        JOIN reward r ON t.idReward = r.id
    -- ca ajoute les infos de la mairie mais seulement si c'est la mairie qui a soumis la récompense... 
    -- ...sinon ca laisse la colonne vide (null)   
        LEFT JOIN city_hall ch ON r.idCityHall = ch.id
        LEFT JOIN partner p ON r.idPartner = p.id
    -- ca regroupe les résultat par récompense pour éviter les doublon...
    -- ...et calculé les totals comme COUNT(t.id)
    -- on veut savoir combien de fois chaque récompense a été acheté
        GROUP BY r.id
    ";

    // requête SQL pour récupérer toutes les transactions et les infos sur les récompenses
    $statement = $dbConnection->prepare($query);

    // exécute la requête SQL
    $statement->execute();

    // ca retourne les résultats en tant que tableau associatif
    return $statement->fetchAll(PDO::FETCH_ASSOC);

    // (cette récompense a été achetée X fois)
}

function getPurchasersByReward($idReward, $dbConnection)
{
    // ca prépare la requete SQL pour récupérer les information des jeunes...
    // ...qui ont acheté une récompense
    $query = "SELECT u.first_name, u.name, t.transaction_date
              FROM transaction t
              JOIN user u ON t.idUser = u.id
              WHERE t.idReward = :idReward
    ";
    $statement = $dbConnection->prepare($query);

    // ca lie l'identifiant de la récompense à la requête pour récupérer les bons résultats
    $statement->bindParam(':idReward', $idReward, PDO::PARAM_INT);

    // ca exécute la requete pour récupérer les données à la BDD
    $statement->execute();

    // ca retourne les résultats en tant que tableau associatif
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
