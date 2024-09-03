<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/cart.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // vérifie si c'est un formulaire POST
    $idReward = intval($_POST['idReward']); // récupére l'id de la récompense
    addToCart($idReward); // ajoute la récompense au panier
    $_SESSION['success'] = "récompense ajoutée au panier."; // message de succès
    header('Location: /ctrl/reward/rewards.php'); // redirige vers la page des récompense
    exit();
}