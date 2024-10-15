<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/phpmailer/phpmailer/src/Exception.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/phpmailer/phpmailer/src/SMTP.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/lib/password.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dbConnection = getConnection($dbConfig);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $user = getUserByEmail($email, $dbConnection);
    
    if ($user) {
        $token = bin2hex(random_bytes(16));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        savePasswordResetToken($email, $token, $expiry, $dbConnection);
        
        $resetLink = " https://motiv.alwaysdata.net/ctrl/password/display-reset-password.php?token=$token";
        
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
            $mail->Subject = 'Réinitialisation de mot de passe';
            $mail->Body    = "Cliquez sur ce lien pour réinitialiser votre mot de passe: <a href='$resetLink'>$resetLink</a>";

            $mail->send();
            $_SESSION['success'] = 'Un email de réinitialisation a été envoyé.';
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur lors de l'envoi de l'email. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $_SESSION['error'] = 'Aucun utilisateur trouvé avec cet email.';
    }
    
    header('Location: /ctrl/login/login-display.php');
    exit();
}