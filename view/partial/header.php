<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';
?>

<!DOCTYPE html>
<html lang="en">

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
        
        <!-- liens vers le profile de chaque role -->
        <?php if (isset($_SESSION['user'])) : ?>
            <a href="<?php echo getProfileLink($_SESSION['user']['idRole']); ?>">Mon Profil</a>
        <?php endif; ?>
    </header>