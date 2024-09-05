<h1>Votre Panier</h1>

<?php if (!empty($rewards)) : ?>
    <ul>
        <?php
        $subTotal = 0; // initialise le sous-total à 0
        foreach ($rewards as $reward) :
            $subTotal += $reward['reward_price']; // ajoute le prix de chaque récompense au sous-total
        ?>
            <li>
                <h3><?= ($reward['title']) ?></h3> <!-- affiche le titre de la récompense -->
                <p><?= ($reward['description']) ?></p> <!-- affiche la description -->
                <p>Prix: <?= ($reward['reward_price']) ?> points</p> <!-- affiche le prix -->

                <form action="/ctrl/cart/remove-from-cart.php" method="POST"> <!-- formulaire pour retirer une récompense -->
                    <input type="hidden" name="idReward" value="<?= ($reward['id']) ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <p><strong>Sous-total: <?= $subTotal ?> points</strong></p> <!-- affiche le sous-total des points -->

    <?php if (isset($_SESSION['user']) && $_SESSION['user']['idRole'] == 60) : ?> <!-- si un jeune est connecté -->
        <a href="/ctrl/cart/checkout.php">Confirmer l'échange</a>
    <?php endif; ?>

<?php else : ?>
    <p>Ton panier est vide.</p>
    <a href="/ctrl/reward/rewards.php">Utilises tes points pour échanger des récompenses</a>
<?php endif; ?>

<?php if (!isset($_SESSION['user']) || $_SESSION['user']['idRole'] != 60) : ?> <!-- si l'utilisateur n'est pas connecté ou n'est pas un jeune -->
    <a href="/ctrl/login/login-display.php">Connecte toi à ton compte</a>
    <a href="/ctrl/login/register-display.php">Inscris-toi et rejoins les motiV</a>
<?php endif; ?>