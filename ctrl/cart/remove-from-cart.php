<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/cart.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // vérifie si c'est un formulaire POST
    $idReward = intval($_POST['idReward']); // récupére l'id de la récompense
    removeFromCart($idReward); // retire la récompense du panier
    $_SESSION['success'] = "récompense retirée du panier."; // message de succès
    header('Location: /ctrl/cart/view-cart.php'); // redirige vers la page du panier
    exit();
}
