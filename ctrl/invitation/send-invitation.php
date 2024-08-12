<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/lib/invitation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/phpmailer/phpmailer/src/Exception.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/phpmailer/phpmailer/src/SMTP.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dbConnection = getConnection($dbConfig);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $entityType = $_POST['entity_type'];
    $entityId = $_POST['entity_id'];
    $token = bin2hex(random_bytes(16));
    $expiry = date('Y-m-d H:i:s', strtotime('+1 day'));

    $associationId = $entityType === 'association' ? $entityId : null;
    $partnerId = $entityType === 'partner' ? $entityId : null;
    $educationalEstablishmentId = $entityType === 'educational_establishment' ? $entityId : null;
    $cityHallId = $entityType === 'city_hall' ? $entityId : null;

    // Définir le rôle en fonction du type d'entité
    if ($entityType === 'association') {
        $idRole = 55; // MB_ASSO
    } elseif ($entityType === 'partner') {
        $idRole = 45; // MB_P
    } elseif ($entityType === 'educational_establishment') {
        $idRole = 25; // Admin de l'établissement scolaire
    } elseif ($entityType === 'city_hall') {
        $idRole = 35; // Admin de la mairie
    }

    if (createInvitation($email, $token, $expiry, $associationId, $partnerId, $educationalEstablishmentId, $cityHallId, $entityType, $idRole, $dbConnection)) {
        $subject = 'Invitation à rejoindre motiV';
        $message = "Cliquez sur le lien pour vous inscrire : http://localhost:50052/ctrl/invitation/register-form.php?token=$token";

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'noreply.motiv@gmail.com';
            $mail->Password = 'znao dcgb lmxl dhuh';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('noreply.motiv@gmail.com', 'motiV');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            $mail->send();
            $_SESSION['success'] = 'Invitation envoyée avec succès.';
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur lors de l'envoi de l'invitation. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $_SESSION['error'] = 'Erreur lors de l\'envoi de l\'invitation.';
    }

    header('Location: /ctrl/profile/display.php');
    exit();
}