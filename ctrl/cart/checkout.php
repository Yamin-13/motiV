<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/cfg/db-dev.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/cart.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/reward.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/message.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/city-hall.php';
include $_SERVER['DOCUMENT_ROOT'] . '/model/lib/partner.php';

$dbConnection = getConnection($dbConfig); // Connexion à la base de données
$idUser = $_SESSION['user']['id']; // Récupére l'id du jeune connecté

// Récupére les items du panier
$cartItems = getCartItems();

foreach ($cartItems as $idReward) { // pour chaque récompense dans le panier....
    $reward = getRewardById($idReward, $dbConnection); // ...on récupère les info de la récompense

    if (!$reward) { // si la récompense n'existe pas
        $_SESSION['error'] = "Récompense introuvable.";
        header('Location: /ctrl/reward/rewards.php');
        exit();
    }

    // ca vérifie si l'utilisateur a déjà échangé cette récompense
    if (hasUserAlreadyRedeemed($idUser, $idReward, $dbConnection)) {
        $_SESSION['error'] = "Tu as déjà échangé cette récompense.";
        header('Location: /ctrl/reward/rewards.php');
        exit();
    }

    // ca vérifie que la récompense est encore dispo
    if ($reward['quantity_available'] <= 0) {
        $_SESSION['error'] = "Cette récompense n'est plus dispo.";
        header('Location: /ctrl/reward/rewards.php');
        exit();
    }

    // ca vérifie que le jeune a assez de points pour échanger cette récompense
    $userPoints = fetchUserRewardPoints($idUser, $dbConnection);
    if ($userPoints < $reward['reward_price']) {
        $_SESSION['error'] = "Tu n'a pas assez de points pour échanger cette récompense.";
        header('Location: /ctrl/reward/rewards.php');
        exit();
    }

    // déduit les points du jeune
    $deducted = deductUserPoints($idUser, $reward['reward_price'], $dbConnection);
    if (!$deducted) { // si ça marche pas
        $_SESSION['error'] = "Erreur lors de la déduction des points.";
        header('Location: /ctrl/reward/rewards.php');
        exit();
    }

    // génère un code unique pour la transaction
    $unique_code = generateUniqueCode();

    // enregistre la transaction
    $transaction = insertTransaction($idUser, $idReward, $reward['reward_price'], $unique_code, $dbConnection);
    if (!$transaction) {
        $_SESSION['error'] = "Erreur lors de l'enregistrement de la transaction.";
        header('Location: /ctrl/reward/rewards.php');
        exit();
    }

    // envoie un message de confirmation
    $sendMessage = sendMessage($idUser, "Récompense échangée", "Tu as échangé la récompense '{$reward['title']}' pour {$reward['reward_price']} points.", $dbConnection);
    if (!$sendMessage) {
        $_SESSION['error'] = "Erreur lors de l'envoi du message de confirmation.";
        header('Location: /ctrl/reward/rewards.php');
        exit();
    }

    // met à jour la quantité dispo de la récompense
    $updated = updateRewardQuantity($idReward, $dbConnection);
    if (!$updated) {
        $_SESSION['error'] = "Erreur lors de la mise à jour de la récompense.";
        header('Location: /ctrl/reward/rewards.php');
        exit();
    }

    // vérifie si la quantité est à zéro après la mise à jour
    if ($reward['quantity_available'] == 1) { // si c'était la dernière récompense
        if ($reward['idCityHall']) {
            $cityHall = getCityHallById($reward['idCityHall'], $dbConnection);
            $submitterId = $cityHall['idUser'];
        } elseif ($reward['idPartner']) {
            $partner = getPartnerById($reward['idPartner'], $dbConnection);
            $submitterId = $partner['idUser'];
        }

        $messageTitle = "Récompense épuisée";
        $messageBody = "La récompense '{$reward['title']}' est maintenant épuisée.";

        // envoie un message au submitter mairie ou partenaire
        sendMessage($submitterId, $messageTitle, $messageBody, $dbConnection);
    }
}

clearCart(); // vide le panier après que toutes les transactions sont faites

// met un message de succès
$_SESSION['success'] = "Ton échange a été effectué avec succès. Tu trouveras tes codes uniques dans ton profil.";

// redirige vers la page des récompenses
header('Location: /ctrl/reward/rewards.php');
exit();
