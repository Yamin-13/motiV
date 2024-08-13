<?php

function addProfessorUser($idUser, $idEducationalEstablishment, $class_name, $dbConnection)
{
  $query = 'INSERT INTO professor_user (idUser, idEducationalEstablishment, class_name) VALUES (:idUser, :idEducationalEstablishment, :class_name)';
  $statement = $dbConnection->prepare($query);
  $statement->bindParam(':idUser', $idUser);
  $statement->bindParam(':idEducationalEstablishment', $idEducationalEstablishment);
  $statement->bindParam(':class_name', $class_name);
  return $statement->execute();
}

// récupère les informations d'un professeur en fonction de l'ID de l'utilisateur
function getProfessorByIdUser($idUser, $dbConnection)
{
  $query = 'SELECT 
                pu.id, 
                pu.class_name, 
                pu.idEducationalEstablishment, 
                ee.name AS establishment_name, 
                ee.RNE_number, 
                ee.unique_code 
              FROM 
                professor_user pu
              JOIN 
                educational_establishment ee ON pu.idEducationalEstablishment = ee.id
              WHERE 
                pu.idUser = :idUser';
  $statement = $dbConnection->prepare($query);
  $statement->bindParam(':idUser', $idUser);
  $statement->execute();
  return $statement->fetch(PDO::FETCH_ASSOC);
}


// récupère la liste des étudiants inscrits par un professeur spécifique...
// ...en fonction de l'ID du professeur
function getStudentsByProfessorId($idProfessor, $dbConnection)
{
  $query = 'SELECT 
                s.id, 
                s.ine_number, 
                s.status 
              FROM 
                student s
              WHERE 
                s.idProfessor = :idProfessor';
  $statement = $dbConnection->prepare($query);
  $statement->bindParam(':idProfessor', $idProfessor);
  $statement->execute();
  return $statement->fetchAll(PDO::FETCH_ASSOC);
}
