<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/asset/css/style.css">
    <title><?= ($titrePage) ?></title>
</head>

<body>
    <header>
        <a href="/ctrl/home/display.php">header</a>
        <a href="/ctrl/home/welcome.php">Page welcome</a>
        <a href="/ctrl/mission/mission-list-public.php">mission</a>
        <a href="/ctrl/reward/rewards.php">Récompenses</a>
        <a href="/ctrl/cart/view-cart.php">Mon Panier</a>

        <?php if (!isset($_SESSION['user'])) : ?> <!-- si l'utilisateur n'est pas connecté -->
            <a href="/ctrl/login/login-display.php">Se connecter</a>
        <?php endif; ?>
        
        <!-- liens vers le profil de chaque rôle -->
        <?php if (isset($_SESSION['user'])) : ?>
            <a href="<?php echo getProfileLink($_SESSION['user']['idRole']); ?>">Mon Profil</a>
            <?php if ($_SESSION['user']['idRole'] == 60 && isset($_SESSION['user']['points'])) : ?> <!-- si l'utilisateur est un jeune et que la clé 'points' existe -->
                <span>Points: <?= $_SESSION['user']['points'] ?> pts</span> <!-- affiche le nombre de points -->
            <?php endif; ?>
        <?php endif; ?>
    </header>