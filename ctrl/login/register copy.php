<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';

$_SESSION['msg']['info'] = [];
$_SESSION['msg']['error'] = [];

$uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . '/upload/';

// Lis les informations saisies dans le formulaire
$fileName = $_FILES['file']['name'];
$fileSize = $_FILES['file']['size'];
$fileTmpName  = $_FILES['file']['tmp_name'];
$fileType = $_FILES['file']['type'];

const MY_IMG_PNG = 'image/png';
const MY_IMG_JPG = 'image/jpeg';
const LIST_ACCEPTED_FILE_TYPE = [MY_IMG_PNG, MY_IMG_JPG];
const FILE_MAX_SIZE = 10;


// récupére les informations du formulaire...
$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);
$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);
$name = htmlspecialchars($_POST['name'] ?? ''); 
$firstName = htmlspecialchars($_POST['first_name'] ?? ''); 
$address = htmlspecialchars($_POST['address'] ?? ''); 
$dateOfBirth = htmlspecialchars($_POST['date_of_birth'] ?? ''); 
$points = 0;

// ...et hache le mot de passe
$hashedPassword = password_hash($password, PASSWORD_BCRYPT); // PASSWORD_BCRYPT ca utilise l'algorithme Blowfish qui est plus sécurisé (survole de la documentation...)

$idRole = 60; // ca donne un role pour les nouveaux utilisateurs (sampleUser)

// se connecte à la base de données

$dbConnection = getConnection($dbConfig);

// Effectue différents tests sur les données saisies
$isSupportedFileType = in_array($fileType, LIST_ACCEPTED_FILE_TYPE);
if (!$isSupportedFileType) {

    // Ajoute un flash-message
    $_SESSION['msg']['error'][] = 'Les seuls formats de fichier acceptés sont : ' . implode(',', LIST_ACCEPTED_FILE_TYPE);
}
if (true) {
    //...filesize
}

$hasErrors = !empty($_SESSION['msg']['error']);
if ($hasErrors) {

    // Redirige vers le formulaire pour corrections
    header('Location: ' . '/ctrl/login/register-display.php');
    exit();
}

// Redimensionne l'image
$imgOriginal;
if ($fileType == MY_IMG_PNG) {
    $imgOriginal = imagecreatefrompng($fileTmpName);
}
if ($fileType == MY_IMG_JPG) {
    $imgOriginal = imagecreatefromjpeg($fileTmpName);
}
$img = imagescale($imgOriginal, 200);
imagepng($img, $fileTmpName);

// Copie aussi le fichier d'avatar dans un répertoire
$uploadPath = $uploadDirectory . basename($fileName);
$didUpload = move_uploaded_file($fileTmpName, $uploadPath);

// condition pour affiché les messages de succès ou d'échec
if (addUser($email, $name, $firstName, $hashedPassword, $idRole, $fileName, $address, $dateOfBirth, $points, $ine_number, $dbConnection)) {  // Apel de la fonction addUser avec les arguments  
    $_SESSION['success'] = 'Inscription réussie.<br>Vous pouvez maintenant vous connecter.'; // le message sera stocké dans la variable de session "succes" 
    header('Location: /ctrl/login/login-display.php');
    exit(); // ca arrete l'execution du script ici
} else {
    $_SESSION['error'] = 'Erreur lors de l\'inscription.<br> Veuillez réessayer.';
    header('Location: /ctrl/login/login-display.php');
    exit();
}
