<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/invitation.php';
include $_SERVER['DOCUMENT_ROOT'] . '/vendor/phpmailer/phpmailer/src/Exception.php';
include $_SERVER['DOCUMENT_ROOT'] . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
include $_SERVER['DOCUMENT_ROOT'] . '/vendor/phpmailer/phpmailer/src/SMTP.php';
include $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = htmlspecialchars($_POST['email']);
    $role = (int)$_POST['role'];
    $token = bin2hex(random_bytes(16));
    $expiry = date('Y-m-d H:i:s', strtotime('+1 day'));

    $dbConnection = getConnection($dbConfig);

    $query = 'INSERT INTO invitation (email, token, expiry, idRole) VALUES (:email, :token, :expiry, :idRole)';
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':token', $token);
    $statement->bindParam(':expiry', $expiry);
    $statement->bindParam(':idRole', $role);

    if ($statement->execute()) {
        $link = "http://localhost:50052/ctrl/invitation/admin-send-register-via-invitation.php?token=$token";
        $subject = "Invitation à s'inscrire sur notre plateforme";
        $message = "Bonjour,\n\nVeuillez utiliser le lien suivant pour vous inscrire : $link\n\nCe lien est valable pendant 24 heures.";
        $headers = 'From: noreply.motiv@gmail.com';

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
        $_SESSION['error'] = 'Erreur lors de la génération de l\'invitation.';
    }

    header('Location: /ctrl/invitation/admin-invitation-form.php');
    exit();
}