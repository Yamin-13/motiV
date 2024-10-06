<?php

// Cette fonction ajoute un nouvel établissement éducatif à la base de données
function addEducationalEstablishment($name, $email, $phoneNumber, $address, $RNE_number, $idUser, $dbConnection)
{
    // Génère un code unique pour l'établissement en appelant la fonction generateUniqueCode()
    $uniqueCode = generateUniqueCode();

    // Prépare une requête SQL pour insérer les informations de l'établissement dans la table 'educational_establishment'
    $query = 'INSERT INTO educational_establishment (name, email, phone_number, address, RNE_number, idUser, unique_code) 
              VALUES (:name, :email, :phone_number, :address, :RNE_number, :idUser, :unique_code)';
    $statement = $dbConnection->prepare($query);

    // Lie les paramètres de la requête aux variables fournies pour éviter les injections SQL
    $statement->bindParam(':name', $name);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':phone_number', $phoneNumber);
    $statement->bindParam(':address', $address);
    $statement->bindParam(':RNE_number', $RNE_number);
    $statement->bindParam(':idUser', $idUser);
    $statement->bindParam(':unique_code', $uniqueCode);

    // Exécute la requête et retourne le résultat (true si succès, false si échec)
    return $statement->execute();
}

// Cette fonction récupère les informations d'un établissement éducatif en fonction de l'ID de l'utilisateur (administrateur)
function getEducationalEstablishmentByIdUser($idUser, $dbConnection)
{
    // Prépare une requête SQL pour sélectionner les détails de l'établissement et de son administrateur
    $query = 'SELECT ee.id, ee.name, ee.email, ee.phone_number, ee.address, ee.RNE_number, ee.unique_code, u.name AS admin_name, u.first_name AS admin_first_name 
              FROM educational_establishment ee
              JOIN user u ON ee.idUser = u.id
              WHERE ee.idUser = :idUser';
    $statement = $dbConnection->prepare($query);

    // Lie l'ID de l'utilisateur au paramètre de la requête
    $statement->bindParam(':idUser', $idUser);

    // Exécute la requête
    $statement->execute();

    // Récupère le premier résultat sous forme de tableau associatif
    return $statement->fetch(PDO::FETCH_ASSOC);
}

// Cette fonction récupère tous les membres (utilisateur) associé à un établissement éducatif spécifique
function getMembersByEducationalId($educationalId, $dbConnection)
{
    // Prépare une requête SQL pour sélectionner les membres liés à l'établissement
    $query = 'SELECT u.id, u.first_name, u.name, u.email 
              FROM user u 
              JOIN educational_establishment_user eeu ON u.id = eeu.idUser 
              WHERE eeu.idEducationalEstablishment = :idEducational';
    $statement = $dbConnection->prepare($query);

    // Lie l'ID de l'établissement au paramètre de la requête
    $statement->bindParam(':idEducational', $educationalId);

    // Exécute la requête
    $statement->execute();

    // Retourne tous les résultats sous forme de tableau associatif
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

// Cette fonction met à jour les information d'un établissement éducatif existant
function updateEducationalEstablishment($id, $name, $phoneNumber, $address, $email, $RNE_number, $dbConnection)
{
    // Prépare une requête SQL pour mettre à jour les détails de l'établissement
    $query = 'UPDATE educational_establishment 
              SET name = :name, phone_number = :phone_number, address = :address, email = :email, RNE_number = :RNE_number
              WHERE id = :id';
    $statement = $dbConnection->prepare($query);

    // Lie les nouvelles valeurs aux paramètres de la requête
    $statement->bindParam(':name', $name);
    $statement->bindParam(':phone_number', $phoneNumber);
    $statement->bindParam(':address', $address);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':RNE_number', $RNE_number);
    $statement->bindParam(':id', $id);

    // Exécute la requête et retourne le résultat de l'opération
    return $statement->execute();
}

// Cette fonction récupère les informations d'un établissement éducatif en fonction de son ID
function getEducationalEstablishmentById($id, $dbConnection)
{
    // Prépare une requête SQL pour sélectionner les détails de l'établissement
    $query = 'SELECT id, name, email, phone_number, address, RNE_number, idUser 
              FROM educational_establishment 
              WHERE id = :id';
    $statement = $dbConnection->prepare($query);

    // Lie l'ID de l'établissement au paramètre de la requête
    $statement->bindParam(':id', $id);

    // Exécute la requête
    $statement->execute();

    // Retourne le résultat sous forme de tableau associatif
    return $statement->fetch(PDO::FETCH_ASSOC);
}

// Cette fonction récupère l'établissement éducatif associé à un membre spécifique (par exemple, un enseignant)
function getEducationalEstablishmentByIdMember($idUser, $dbConnection)
{
    // Prépare une requête SQL pour sélectionner l'établissement lié à l'utilisateur
    $query = 'SELECT ee.id, ee.name, ee.email, ee.phone_number, ee.address, ee.RNE_number, u.name AS admin_name, u.first_name AS admin_first_name
              FROM educational_establishment ee
              JOIN educational_establishment_user eeu ON ee.id = eeu.idEducationalEstablishment
              JOIN user u ON ee.idUser = u.id
              WHERE eeu.idUser = :idUser';
    $statement = $dbConnection->prepare($query);

    // Lie l'ID de l'utilisateur au paramètre de la requête
    $statement->bindParam(':idUser', $idUser);

    // Exécute la requête
    $statement->execute();

    // Retourne le résultat sous forme de tableau associatif
    return $statement->fetch(PDO::FETCH_ASSOC);
}

// Cette fonction récupère tous les établissements éducatifs avec les informations de leurs administrateurs
function getEducationalEstablishmentsWithAdmins($dbConnection)
{
    // Prépare une requête SQL pour sélectionner les établissements et les détails des administrateurs
    $query = "SELECT ee.id, ee.name AS establishment_name, u.name AS admin_name, u.first_name AS admin_first_name, u.email AS admin_email
              FROM educational_establishment ee
              JOIN user u ON ee.idUser = u.id";
    $statement = $dbConnection->prepare($query);

    // Exécute la requête
    $statement->execute();

    // Retourne tous les résultats sous forme de tableau associatif
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

// Cette fonction récupère tous les établissements éducatifs avec des détails supplémentaires tels que le numéro de téléphone
function getEducationalEstablishmentsWithDetails($dbConnection)
{
    // Prépare une requête SQL pour sélectionner les établissements avec des informations supplémentaires
    $query = "SELECT ee.id, 
                ee.name AS establishment_name, 
                u.name AS admin_name, 
                u.first_name AS admin_first_name, 
                u.email AS admin_email,
                ee.phone_number AS establishment_phone_number
            FROM educational_establishment ee
            JOIN user u ON ee.idUser = u.id";
    $statement = $dbConnection->prepare($query);

    // Exécute la requête
    $statement->execute();

    // Retourne tous les résultats sous forme de tableau associatif
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

// Cette fonction génère un code unique composé de chiffres et de lettres pour un établissement éducatif
function generateUniqueCode()
{
    // Génère un nombre aléatoire de 8 chiffres
    $digits = mt_rand(10000000, 99999999);

    // Génère deux lettres majuscules aléatoires
    $letters = chr(mt_rand(65, 90)) . chr(mt_rand(65, 90)); // A à Z en ASCII

    // Combine les chiffres et les lettres pour former le code unique
    return $digits . $letters;
}

// Cette fonction récupère un établissement éducatif en utilisant son numéro RNE et son code unique
function getEducationalEstablishment($rne, $uniqueCode, $dbConnection, $selectAll = false)
{
    // Détermine les colonnes à sélectionner en fonction du paramètre $selectAll en utilisant un opérateur ternaire pour remplacer if else
    $columns = $selectAll ? 'id, name, email, phone_number, address, RNE_number, unique_code, idUser' : 'id';
    // $selectAll = condition
    // Prépare une requête SQL pour sélectionner l'établissement correspondant
    $query = "SELECT $columns FROM educational_establishment WHERE RNE_number = :rne AND unique_code = :unique_code";
    $statement = $dbConnection->prepare($query);

    // Lie les paramètres à leurs valeurs respectives
    $statement->bindParam(':rne', $rne);
    $statement->bindParam(':unique_code', $uniqueCode);

    // Exécute la requête
    $statement->execute();

    // Retourne le résultat sous forme de tableau associatif
    return $statement->fetch(PDO::FETCH_ASSOC);
}

// Cette fonction récupère les professeurs et leurs étudiants associés pour un établissement donné
function getProfessorStudentsByEstablishment($idEducationalEstablishment, $dbConnection)
{
    // Prépare la requête SQL pour sélectionner les professeurs et leurs étudiants
    $query = "SELECT 
            pu.id AS professor_id, 
            pu.class_name, 
            u.first_name AS professor_first_name, 
            u.name AS professor_name, 
            s.id AS student_id, 
            s.ine_number, 
            s.status,
            us.id AS user_id,
            us.first_name AS student_first_name,  
            us.name AS student_name             
        FROM professor_user pu
        JOIN user u ON pu.idUser = u.id
        LEFT JOIN student s ON s.idProfessor = pu.id
        LEFT JOIN user us ON us.ine_number = s.ine_number
        WHERE pu.idEducationalEstablishment = :idEducationalEstablishment
        ORDER BY pu.class_name, u.name, s.ine_number
    ";

    // Prépare la requête SQL
    $statement = $dbConnection->prepare($query);

    // Lie le paramètre :idEducationalEstablishment à la valeur $idEducationalEstablishment
    $statement->bindParam(':idEducationalEstablishment', $idEducationalEstablishment);

    // Exécute la requête
    $statement->execute();

    // Récupère tous les résultats sous forme de tableau associatif
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Crée un tableau pour stocker les professeurs et leurs étudiants
    $professors = [];

    // Parcourt chaque ligne du résultat pour organiser les données
    foreach ($results as $row) {
        // Récupère l'ID du professeur
        $professorId = $row['professor_id'];

        // Si le professeur n'est pas déjà dans le tableau, on l'ajoute
        if (!isset($professors[$professorId])) {
            // Ajoute le professeur au tableau
            $professors[$professorId] = [
                'id' => $professorId,
                'class_name' => $row['class_name'],
                'first_name' => $row['professor_first_name'],
                'name' => $row['professor_name'],
                'students' => [] // Initialise un tableau vide pour les étudiants
            ];
        }
        // Vérifie si un étudiant est associé à ce professeur
        if (!empty($row['student_id'])) {
            // Ajoute l'étudiant à la liste des étudiants du professeur
            $professors[$professorId]['students'][] = [
                'id' => $row['student_id'],
                'ine_number' => $row['ine_number'],
                'status' => $row['status'],
                'first_name' => $row['student_first_name'],
                'name' => $row['student_name'],
                'user_id' => $row['user_id']
            ];
        }
    }
    // Convertit le tableau associatif en tableau indexé pour une utilisation plus simple
    $professorsList = array_values($professors);

    // Retourne la liste des professeurs avec leurs étudiants
    return $professorsList;
}


// Cette fonction valide un étudiant en mettant à jour son statut dans la base de données
function validateStudent($studentId, $dbConnection)
{
    // Prépare une requête SQL pour mettre à jour le statut de l'étudiant à "validated"
    $query = 'UPDATE student SET status = "validated" WHERE id = :student_id';
    $statement = $dbConnection->prepare($query);

    // Lie l'ID de l'étudiant au paramètre de la requête
    $statement->bindParam(':student_id', $studentId);

    // Exécute la requête et retourne le résultat de l'opération
    return $statement->execute();
}

// Cette fonction récupère tous les jeunes utilisateurs (étudiants) associés à un établissement éducatif spécifique
function getYoungUsersByEstablishment($idEducationalEstablishment, $dbConnection)
{
    // Prépare une requête SQL pour sélectionner les étudiants qui sont également des utilisateurs enregistrés
    $query = "SELECT 
                u.id, 
                u.name, 
                u.first_name, 
                u.email, 
                u.points 
            FROM user u 
            JOIN student s ON u.ine_number = s.ine_number 
            WHERE s.idEducationalEstablishment = :idEducationalEstablishment
            AND u.idRole = 60"; // Vérifie que l'utilisateur a le rôle de "jeune"
    $statement = $dbConnection->prepare($query);

    // Lie l'ID de l'établissement au paramètre de la requête
    $statement->bindParam(':idEducationalEstablishment', $idEducationalEstablishment);

    // Exécute la requête
    $statement->execute();

    // Retourne tous les résultats sous forme de tableau associatif
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
