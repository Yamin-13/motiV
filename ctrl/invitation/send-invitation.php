<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/lib/invitation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/phpmailer/phpmailer/src/Exception.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/phpmailer/phpmailer/src/SMTP.php';

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

    if (createInvitation($email, $token, $expiry, $associationId, $partnerId, $entityType, $dbConnection)) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'noreply.motiv@gmail.com';
            $mail->Password = 'znao dcgb lmxl dhuh';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('noreply-motiv@gmail.com', 'motiV');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Invitation à rejoindre motiV';
            $mail->Body    = "Cliquez sur le lien pour vous inscrire : http://localhost/ctrl/invitation/register-form.php?token=$token";

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
