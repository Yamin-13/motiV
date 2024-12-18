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
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/mission.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/contact.php';

$titrePage = "Profile | MotiV – La plateforme qui valorise l'effort";

// Vérification du rôle de l'utilisateur
$idRole = $_SESSION['user']['idRole'];
if (!in_array($idRole, [10, 20, 25, 27, 30, 35, 40, 45, 50, 55])) {
    header('Location: /ctrl/login/login-display.php');
    exit();
}

$dbConnection = getConnection($dbConfig);
$user = $_SESSION['user'];

$mission = null;
$young = null;

if (isset($_GET['mission_id']) && isset($_GET['user_id'])) {
    $missionId = $_GET['mission_id'];
    $userId = $_GET['user_id'];
    $mission = getMissionById($missionId, $dbConnection);
    $young = getUserById($userId, $dbConnection);
}

// Fonction pour récupérer les messages envoyés à l'admin
$sentMessages = getContactMessagesByUser($user['id'], $dbConnection);

// Fonction pour récupérer les réponses de l'admin
$receivedMessages = getMessagesByidUser($user['id'], $dbConnection);

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';

$members = [];
$admin = null;
$educationalEstablishment = null;
$students = [];

if ($idRole == 50 || $idRole == 55) {
    $association = ($idRole == 50) ? getAssociationByidUser($user['id'], $dbConnection) : getAssociationByidMember($user['id'], $dbConnection);
    $members = $association ? getMembersByAssociationId($association['id'], $dbConnection) : [];
    // pour récupérer les missions en attente de validation
    $missions = getPendingMissionsForAssociation($association['id'], $dbConnection);
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
