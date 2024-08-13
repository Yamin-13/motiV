<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/association.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/partner.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/educational-establishment.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/city-hall.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/verification.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/message.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/professor.php'; 
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/student.php'; 

$titrePage = "motiV";

// Vérification du rôle de l'utilisateur
$idRole = $_SESSION['user']['idRole'];
if (!in_array($idRole, [10, 20, 25, 27, 30, 35, 40, 45, 50, 55])) { 
    header('Location: /ctrl/login/login-display.php');
    exit();
}

$dbConnection = getConnection($dbConfig);
$user = $_SESSION['user'];

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';

$members = [];
$admin = null;
$educationalEstablishment = null; 
$students = [];

if ($idRole == 50 || $idRole == 55) {
    $association = ($idRole == 50) ? getAssociationByidUser($user['id'], $dbConnection) : getAssociationByidMember($user['id'], $dbConnection);
    $members = $association ? getMembersByAssociationId($association['id'], $dbConnection) : [];
    include $_SERVER['DOCUMENT_ROOT'] . '/view/profile/association-display.php';
} elseif ($idRole == 40 || $idRole == 45) {
    $partner = ($idRole == 40) ? getPartnerByidUser($user['id'], $dbConnection) : getPartnerByidMember($user['id'], $dbConnection);
    $members = $partner ? getMembersByPartnerId($partner['id'], $dbConnection) : [];
    include $_SERVER['DOCUMENT_ROOT'] . '/view/profile/partner-display.php';
} elseif ($idRole == 20 || $idRole == 25) {
    $educationalEstablishment = ($idRole == 20) ? getEducationalEstablishmentByIdUser($user['id'], $dbConnection) : getEducationalEstablishmentByidMember($user['id'], $dbConnection);
    $members = $educationalEstablishment ? getMembersByEducationalId($educationalEstablishment['id'], $dbConnection) : [];
    include $_SERVER['DOCUMENT_ROOT'] . '/view/educational-establishment/profile.php';
} elseif ($idRole == 27) { 
    $professor = getProfessorByIdUser($user['id'], $dbConnection); 
    if ($professor) {
        $educationalEstablishment = getEducationalEstablishmentById($professor['idEducationalEstablishment'], $dbConnection);
        $students = getStudentsByProfessorId($professor['id'], $dbConnection);
    }
    include $_SERVER['DOCUMENT_ROOT'] . '/view/professor/profile.php';
} elseif ($idRole == 30 || $idRole == 35) {
    $cityHall = ($idRole == 30) ? getCityHallByIdUser($user['id'], $dbConnection) : getCityHallByidMember($user['id'], $dbConnection);
    $members = $cityHall ? getMembersByCityHallId($cityHall['id'], $dbConnection) : [];
    $admin = getUserById($cityHall['idUser'], $dbConnection);
    include $_SERVER['DOCUMENT_ROOT'] . '/view/city-hall/profile.php';
}

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';
