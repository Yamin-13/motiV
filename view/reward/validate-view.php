<?php
if (isset($_SESSION['success'])) {
    echo '<p class="success">' . $_SESSION['success'] . '</p>';
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo '<p class="error">' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
}

if (isset($reward) && $reward) : ?>
    <h1>Récompense: <?= ($reward['title']) ?></h1>
    <img src="/upload/<?= ($reward['image_filename']) ?>" alt="<?= ($reward['title']) ?>" width="200">
    <p>Description: <?= ($reward['description']) ?></p>
    <p>Prix: <?= ($reward['reward_price']) ?> points</p>
    <p>Nom du jeune: <?= ($reward['first_name'] . ' ' . $reward['name']) ?></p>

    <!-- Formulaire pour valider la récompense -->
    <form method="POST" action="">
        <input type="hidden" name="code" value="<?= ($code) ?>">
        <button type="submit" name="validate">Valider</button>
    </form>
<?php else : ?>
    <p>Code invalide ou déjà utilisé.</p>
<?php endif; ?>

<a href="/ctrl/reward/rewards.php">Retour aux récompenses</a>