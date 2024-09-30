<?php

// ajoute une récompense au panier
function addToCart($idReward) {
    if (!isset($_SESSION['cart'])) { // si le panier n'existe pas encore on le crée
        $_SESSION['cart'] = []; // créer un tableau vide pour le panier
    }
    
    if (!in_array($idReward, $_SESSION['cart'])) { // vérifie si la récompense n'est pas déjà dans le panier
        $_SESSION['cart'][] = $idReward; // ajoute la récompense au panier
    }
}

// retire une récompense du panier
function removeFromCart($idReward) {
    if (isset($_SESSION['cart'])) { // vérifie si le panier existe
        $_SESSION['cart'] = array_diff($_SESSION['cart'], [$idReward]); // retire la récompense du panier
    }
}

// récupére toutes les récompense dans le panier
function getCartItems() {
    return $_SESSION['cart'] ?? []; // retourne le panier ou un tableau vide s'il est vide
}

// vide le panier
function clearCart() {
    unset($_SESSION['cart']); // supprime le panier de la session
}
