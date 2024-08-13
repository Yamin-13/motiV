<?php

function addStudent($ine_number, $idProfessor, $idEducationalEstablishment, $dbConnection)
{
  $query = 'INSERT INTO student (ine_number, idProfessor, idEducationalEstablishment) VALUES (:ine_number, :idProfessor, :idEducationalEstablishment)';
  $statement = $dbConnection->prepare($query);
  $statement->bindParam(':ine_number', $ine_number);
  $statement->bindParam(':idProfessor', $idProfessor);
  $statement->bindParam(':idEducationalEstablishment', $idEducationalEstablishment);
  return $statement->execute();
}


// validation pour vérifier que le professeur n'a pas déjà inscrit 8 élèves
function canAddMoreStudents($idProfessor, $dbConnection)
{
  $query = 'SELECT COUNT(*) as total FROM student WHERE idProfessor = :idProfessor';
  $statement = $dbConnection->prepare($query);
  $statement->bindParam(':idProfessor', $idProfessor);
  $statement->execute();
  $result = $statement->fetch(PDO::FETCH_ASSOC);
  return $result['total'] < 8;
}

function validateStudentList($idProfessor, $dbConnection)
{
  $query = 'UPDATE student SET status = "validated" WHERE idProfessor = :idProfessor';
  $statement = $dbConnection->prepare($query);
  $statement->bindParam(':idProfessor', $idProfessor);
  return $statement->execute();
}

function getValidatedStudentsByEstablishment($dbConnection)
{
  $query = 'SELECT 
                s.ine_number, 
                e.name AS establishment_name, 
                p.class_name, 
                u.first_name AS professor_first_name, 
                u.name AS professor_name 
              FROM 
                student s 
              JOIN 
                educational_establishment e ON s.idEducationalEstablishment = e.id 
              JOIN 
                professor_user p ON s.idProfessor = p.id 
              JOIN 
                user u ON p.idUser = u.id 
              WHERE 
                s.status = "validated" 
              ORDER BY 
                e.name, p.class_name, u.first_name, u.name';

  $statement = $dbConnection->prepare($query);
  $statement->execute();
  $results = $statement->fetchAll(PDO::FETCH_ASSOC);

  // regroupe les résultats par établissement scolaire
  $groupedResults = [];
  foreach ($results as $result) {
    $groupedResults[$result['establishment_name']][] = $result;
  }

  return $groupedResults;
}

function getStudentById($id, $dbConnection)
{
  $query = 'SELECT id, ine_number, status FROM student WHERE id = :id';
  $statement = $dbConnection->prepare($query);
  $statement->bindParam(':id', $id);
  $statement->execute();
  return $statement->fetch(PDO::FETCH_ASSOC);
}

function updateStudent($id, $ine_number, $dbConnection)
{
  $query = 'UPDATE student SET ine_number = :ine_number WHERE id = :id AND status = "pending"';
  $statement = $dbConnection->prepare($query);
  $statement->bindParam(':ine_number', $ine_number);
  $statement->bindParam(':id', $id);
  return $statement->execute();
}

function deleteStudent($id, $dbConnection)
{
  $query = 'DELETE FROM student WHERE id = :id AND status = "pending"';
  $statement = $dbConnection->prepare($query);
  $statement->bindParam(':id', $id);
  return $statement->execute();
}

function validateClass($classId, $dbConnection)
{
    $query = 'UPDATE student SET status = "validated" WHERE idProfessor = :classId AND status = "pending"';
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':classId', $classId);
    return $statement->execute();
}
