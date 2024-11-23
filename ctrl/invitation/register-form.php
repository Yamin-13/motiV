<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/invitation.php';
$titrePage = "Inscription D'entité | MotiV – La plateforme qui valorise l'effort";

$dbConnection = getConnection($dbConfig);

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $invitation = getInvitationByToken($token, $dbConnection);

    if (!$invitation) {
        die('Invitation invalide ou expirée.');
    }

    // Stocker l'invitation dans la session
    $_SESSION['invitation'] = $invitation;
}

$invitation = $_SESSION['invitation'] ?? null;

if (!$invitation) {
    die('Invitation invalide ou expirée.');
}

if (isset($_SESSION['error'])): ?>
    <div class="error-message"><?= $_SESSION['error'] ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>
<?php if (isset($_SESSION['success'])): ?>
    <div class="success-message"><?= $_SESSION['success'] ?></div>
    <?php unset($_SESSION['success']); ?>
<?php endif;

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/invitation/register-form.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';