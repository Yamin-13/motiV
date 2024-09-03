<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/cart.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/reward.php';

$dbConnection = getConnection($dbConfig); // connexion à la base de données
$titrePage = "motiV";

$cartItems = getCartItems(); // récupére les item du panier
$rewards = []; // tableau pour stocké les récompenses

foreach ($cartItems as $idReward) {
    $rewards[] = getRewardById($idReward, $dbConnection); // ajoute chaque récompense dans le tableau
}

include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/cart/view-cart.php';
include $_SERVER['DOCUMENT_ROOT'] . '/view/partial/footer.php';