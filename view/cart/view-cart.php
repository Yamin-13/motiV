<main class="main-content">
<h1 class="cart-title">Votre Panier</h1>

<?php if (!empty($rewards)) : ?>
    <ul class="cart-items">
        <?php
        $subTotal = 0; // initialise le sous-total à 0
        foreach ($rewards as $reward) :
            $subTotal += $reward['reward_price']; // ajoute le prix de chaque récompense au sous-total
        ?>
            <li class="cart-item">
                <h3 class="cart-item-title"><?= ($reward['title']) ?></h3>
                <p class="cart-item-description"><?= ($reward['description']) ?></p>
                <p class="cart-item-price">Prix: <?= ($reward['reward_price']) ?> points</p>

                <form action="/ctrl/cart/remove-from-cart.php" method="POST" class="cart-remove-form">
                    <input type="hidden" name="idReward" value="<?= ($reward['id']) ?>">
                    <button type="submit" class="cart-btn-remove">Supprimer</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <p class="cart-subtotal"><strong>Sous-total: <?= $subTotal ?> points</strong></p>

    <?php if (isset($_SESSION['user']) && $_SESSION['user']['idRole'] == 60) : ?>
        <a href="/ctrl/cart/checkout.php" class="cart-btn-checkout">Confirmer l'échange</a>
    <?php endif; ?>

<?php else : ?>
    <p class="cart-empty-message">Ton panier est vide.</p>
    <a href="/ctrl/reward/rewards.php" class="cart-btn-rewards">Utilises tes points pour échanger des récompenses</a>
<?php endif; ?>

<?php if (!isset($_SESSION['user']) || $_SESSION['user']['idRole'] != 60) : ?>
    <a href="/ctrl/login/login-display.php" class="cart-btn-login">Connecte toi à ton compte</a>
    <a href="/ctrl/login/register-display.php" class="cart-btn-register">Inscris-toi et rejoins les motiV</a>
<?php endif; ?>
</main>