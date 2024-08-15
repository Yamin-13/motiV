<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/lib/student.php';

$dbConnection = getConnection($dbConfig);

// Récupére l'ID utilisateur de la session
$userId = $_SESSION['user']['id'];

// Récupére les données soumises
$newFirstName = $_POST['first_name'];
$newName = $_POST['name'];
$newDateOfBirth = $_POST['date_of_birth'];
$newAddress = $_POST['address'];
$ineNumber = $_POST['ine_number'];

// Connexion à la base de données
$dbConnection = getConnection($dbConfig);

// Vérifie si le numéro INE existe et est validé dans la table `student`
$student = getStudentByIne($ineNumber, $dbConnection);

if ($student) {
    // Met à jour les informations de l'étudiant dans la table `student`
    updateStudentInfo($student['id'], $newName, $newFirstName, $_SESSION['user']['email'], $dbConnection);
}

// Met à jour le profil de l'utilisateur dans la table `user`
updateUserProfile($userId, $newName, $_SESSION['user']['email'], $_SESSION['user']['avatar_filename'], $newFirstName, $_SESSION['user']['password'], $_SESSION['user']['idRole'], $ineNumber, $newAddress, $newDateOfBirth, $dbConnection);

// Mise à jour des informations de session
$_SESSION['user']['name'] = $newName;
$_SESSION['user']['first_name'] = $newFirstName;
$_SESSION['user']['date_of_birth'] = $newDateOfBirth;
$_SESSION['user']['address'] = $newAddress;
if ($ineNumber !== '') {
    $_SESSION['user']['ine_number'] = $ineNumber;
}

// Ajout d'un message de confirmation
$_SESSION['success'] = "Votre profil a été mis à jour avec succès.";


header('Location: /view/home/welcome.php');
exit();
