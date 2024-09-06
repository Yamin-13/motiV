<?php
// Gère le traitement des donnée soumises via le formulaire
session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/reward.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/city-hall.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/partner.php';

// Connexion à la base de données
$dbConnection = getConnection($dbConfig);

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header('Location: /ctrl/login/login-display.php');
    exit();
}

// Vérifie le rôle
$idRole = $_SESSION['user']['idRole'];
$allowedRoles = [30, 35, 45, 40];

if (!in_array($idRole, $allowedRoles)) {
    $_SESSION['error'] = "Vous n'avez pas la permission d'effectuer cette action.";
    header('Location: /ctrl/profile/display.php');
    exit();
}

// Vérifie que les donnée du formulaire sont présentes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $reward_price = trim($_POST['reward_price']);
    $quantity_available = trim($_POST['quantity_available']);
    $idCategory = trim($_POST['idCategory']);
    $idUser = $_SESSION['user']['id'];

    // Récupère les dates soumises
    $start_date_usage = !empty($_POST['start_date_usage']) ? $_POST['start_date_usage'] : null;
    $expiration_date = !empty($_POST['expiration_date']) ? $_POST['expiration_date'] : null;

    // si y'a aucune date d'expiration est donnée définie une expiration dans 6 mois
    if ($expiration_date === null) {
        $expiration_date = date('Y-m-d', strtotime('+6 months'));
    }

    // Validation des donnée
    if (empty($title) || empty($description) || empty($reward_price) || empty($quantity_available)) {
        $_SESSION['error'] = "Veuillez remplir tous les champs obligatoires.";
        header('Location: /ctrl/reward/submit-reward.php');
        exit();
    }

    // Gestion de l'upload de l'image
    $image_filename = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

        $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $image_filename = $newFileName;
            } else {
                $_SESSION['error'] = "Il y a eu un problème lors de l'upload de l'image.";
                header('Location: /ctrl/reward/submit-reward.php');
                exit();
            }
        } else {
            $_SESSION['error'] = "Type de fichier non autorisé pour l'image.";
            header('Location: /ctrl/reward/submit-reward.php');
            exit();
        }
    }

    // Récupère l'ID de la mairie ou du partenaire depuis la session utilisateur
    $idCityHall = null;
    $idPartner = null;

    if ($idRole == 30) {
        $idCityHall = getCityHallIdByUserId($idUser, $dbConnection);
    } elseif ($idRole == 40) {
        $idPartner = getPartnerIdByUserId($idUser, $dbConnection);
    }

    // Vérifie que l'ID de la mairie ou du partenaire a été correctement récupéré
    if ($idCityHall === null && $idPartner === null) {
        $_SESSION['error'] = "Erreur : impossible de déterminer l'entité soumettant la récompense.";
        header('Location: /ctrl/reward/submit-reward.php');
        exit();
    }

    // Insère la récompense dans la base de données
    $insertedRewardId = submitReward($title, $description, $reward_price, $quantity_available, $image_filename, $idUser, $idCategory, $idCityHall, $idPartner, $start_date_usage, $expiration_date, $dbConnection);

    if ($insertedRewardId) {
        $_SESSION['success'] = "Récompense soumise avec succès.";
        header('Location: /ctrl/profile/display.php');
        exit();
    } else {
        $_SESSION['error'] = "Erreur lors de la soumission de la récompense.";
        header('Location: /ctrl/reward/submit-reward.php');
        exit();
    }
}