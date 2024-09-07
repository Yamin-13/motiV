<?php
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/comment.php';

// Connexion à la base de données
$dbConnection = getConnection($dbConfig);

// Vérifie que l'ID de la récompense est présent
if (!isset($_GET['idReward'])) {
    $_SESSION['error'] = "Récompense introuvable.";
    header('Location: /ctrl/reward/rewards.php');
    exit();
}

$idReward = intval($_GET['idReward']);

// Ajoute un commentaire si l'utilisateur est connecté
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user']) && !isset($_POST['editCommentId'])) {
    $idUser = $_SESSION['user']['id'];
    $commentText = trim($_POST['comment']);

    if (!empty($commentText)) {
        addComment($idReward, $idUser, $commentText, $dbConnection);
        $_SESSION['success'] = "Commentaire ajouté avec succès.";
        header('Location: /ctrl/reward/reward-details.php?idReward=' . $idReward);
        exit();
    }
}

// Modifie un commentaire
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user']) && isset($_POST['editCommentId'])) {
    $commentId = intval($_POST['editCommentId']);
    $commentText = trim($_POST['editComment']);

    // Vérifie si le commentaire appartient à l'utilisateur ou si c'est un admin
    $comment = getCommentById($commentId, $dbConnection);

    if ($comment && ($comment['idUser'] == $_SESSION['user']['id'] || $_SESSION['user']['idRole'] == 10)) {
        updateComment($commentId, $commentText, $dbConnection);
        $_SESSION['success'] = "Commentaire modifié avec succès.";
    } else {
        $_SESSION['error'] = "Vous n'avez pas la permission de modifier ce commentaire.";
    }

    header('Location: /ctrl/reward/reward-details.php?idReward=' . $idReward);
    exit();
}

// Supprime un commentaire
if (isset($_GET['delete']) && isset($_SESSION['user'])) {
    $comment = getCommentById($_GET['delete'], $dbConnection);

    if ($comment && ($_SESSION['user']['id'] == $comment['idUser'] || $_SESSION['user']['idRole'] == 10)) {
        deleteComment($_GET['delete'], $dbConnection);
        $_SESSION['success'] = "Commentaire supprimé avec succès.";
    } else {
        $_SESSION['error'] = "Vous n'avez pas la permission de supprimer ce commentaire.";
    }

    header('Location: /ctrl/reward/reward-details.php?idReward=' . $idReward);
    exit();
}

// Récupére les commentaires associé
$comments = getCommentsByRewardId($idReward, $dbConnection);

foreach ($comments as $key => $comment) {
    $comments[$key]['author_name'] = getAuthorName($comment['idUser'], $dbConnection);
}