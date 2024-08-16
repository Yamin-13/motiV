<?php

function addEducationalEstablishment($name, $email, $phoneNumber, $address, $RNE_number, $idUser, $dbConnection)
{
    $uniqueCode = generateUniqueCode();
    $query = 'INSERT INTO educational_establishment (name, email, phone_number, address, RNE_number, idUser, unique_code) 
              VALUES (:name, :email, :phone_number, :address, :RNE_number, :idUser, :unique_code)';
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':name', $name);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':phone_number', $phoneNumber);
    $statement->bindParam(':address', $address);
    $statement->bindParam(':RNE_number', $RNE_number);
    $statement->bindParam(':idUser', $idUser);
    $statement->bindParam(':unique_code', $uniqueCode);

    return $statement->execute();
}

function getEducationalEstablishmentByIdUser($idUser, $dbConnection)
{
    $query = 'SELECT ee.id, ee.name, ee.email, ee.phone_number, ee.address, ee.RNE_number, ee.unique_code, u.name AS admin_name, u.first_name AS admin_first_name 
              FROM educational_establishment ee
              JOIN user u ON ee.idUser = u.id
              WHERE ee.idUser = :idUser';
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idUser', $idUser);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getMembersByEducationalId($educationalId, $dbConnection)
{
    $query = 'SELECT u.id, u.first_name, u.name, u.email 
              FROM user u 
              JOIN educational_establishment_user eeu ON u.id = eeu.idUser 
              WHERE eeu.idEducationalEstablishment = :idEducational';
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idEducational', $educationalId);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function updateEducationalEstablishment($id, $name, $phoneNumber, $address, $email, $RNE_number, $dbConnection)
{
    $query = 'UPDATE educational_establishment 
              SET name = :name, phone_number = :phone_number, address = :address, email = :email, RNE_number = :RNE_number
              WHERE id = :id';
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':name', $name);
    $statement->bindParam(':phone_number', $phoneNumber);
    $statement->bindParam(':address', $address);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':RNE_number', $RNE_number);
    $statement->bindParam(':id', $id);

    return $statement->execute();
}

function getEducationalEstablishmentById($id, $dbConnection)
{
    $query = 'SELECT id, name, email, phone_number, address, RNE_number, idUser 
              FROM educational_establishment 
              WHERE id = :id';
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':id', $id);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getEducationalEstablishmentByIdMember($idUser, $dbConnection)
{
    $query = 'SELECT ee.id, ee.name, ee.email, ee.phone_number, ee.address, ee.RNE_number, u.name AS admin_name, u.first_name AS admin_first_name
              FROM educational_establishment ee
              JOIN educational_establishment_user eeu ON ee.id = eeu.idEducationalEstablishment
              JOIN user u ON ee.idUser = u.id
              WHERE eeu.idUser = :idUser';
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idUser', $idUser);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getEducationalEstablishmentsWithAdmins($dbConnection)
{
    $query = "
        SELECT ee.id, ee.name AS establishment_name, u.name AS admin_name, u.first_name AS admin_first_name, u.email AS admin_email
        FROM educational_establishment ee
        JOIN user u ON ee.idUser = u.id
    ";
    $statement = $dbConnection->prepare($query);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getEducationalEstablishmentsWithDetails($dbConnection)
{
    $query = "
        SELECT 
            ee.id, 
            ee.name AS establishment_name, 
            u.name AS admin_name, 
            u.first_name AS admin_first_name, 
            u.email AS admin_email,
            ee.phone_number AS establishment_phone_number
        FROM educational_establishment ee
        JOIN user u ON ee.idUser = u.id
    ";
    $statement = $dbConnection->prepare($query);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function generateUniqueCode()
{
    $digits = mt_rand(10000000, 99999999);
    $letters = chr(mt_rand(65, 90)) . chr(mt_rand(65, 90)); // Génère deux lettres aléatoires
    return $digits . $letters;
}

function getEducationalEstablishment($rne, $uniqueCode, $dbConnection, $selectAll = false)
{
    // Sélection des colonnes en fonction du paramètre $selectAll
    $columns = $selectAll ? 'id, name, email, phone_number, address, RNE_number, unique_code, idUser' : 'id';

    $query = "SELECT $columns FROM educational_establishment WHERE RNE_number = :rne AND unique_code = :unique_code";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':rne', $rne);
    $statement->bindParam(':unique_code', $uniqueCode);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getProfessorStudentsByEstablishment($idEducationalEstablishment, $dbConnection)
{
    $query = "
        SELECT 
            pu.id AS professor_id, 
            pu.class_name, 
            u.first_name AS professor_first_name, 
            u.name AS professor_name, 
            s.id AS student_id, 
            s.ine_number, 
            s.status
        FROM professor_user pu
        JOIN user u ON pu.idUser = u.id
        LEFT JOIN student s ON s.idProfessor = pu.id
        WHERE pu.idEducationalEstablishment = :idEducationalEstablishment
        ORDER BY pu.class_name, u.name, s.ine_number
    ";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idEducationalEstablishment', $idEducationalEstablishment);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Regroupement par professeur
    $professorStudents = [];
    foreach ($result as $row) {
        $professorId = $row['professor_id'];
        if (!isset($professorStudents[$professorId])) {
            $professorStudents[$professorId] = [
                'id' => $professorId,
                'class_name' => $row['class_name'],
                'professor_first_name' => $row['professor_first_name'],
                'professor_name' => $row['professor_name'],
                'students' => []
            ];
        }
        if ($row['student_id']) {
            $professorStudents[$professorId]['students'][] = [
                'id' => $row['student_id'],
                'ine_number' => $row['ine_number'],
                'status' => $row['status']
            ];
        }
    }

    return array_values($professorStudents);
}


function validateStudent($studentId, $dbConnection)
{
    $query = 'UPDATE student SET status = "validated" WHERE id = :student_id';
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':student_id', $studentId);
    return $statement->execute();
}

function getYoungUsersByEstablishment($idEducationalEstablishment, $dbConnection) {
    $query = "
        SELECT 
            u.id, 
            u.name, 
            u.first_name, 
            u.email, 
            u.points 
        FROM 
            user u 
        JOIN 
            student s ON u.ine_number = s.ine_number 
        WHERE 
            s.idEducationalEstablishment = :idEducationalEstablishment
            AND u.idRole = 60
    ";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idEducationalEstablishment', $idEducationalEstablishment);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
