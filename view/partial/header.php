<?php
// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Inclusion des fonctions liées à l'utilisateur
include_once $_SERVER['DOCUMENT_ROOT'] . '/model/lib/user.php';

// Vérifier si l'utilisateur est connecté
$loggedInUser = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$isLoggedIn = !is_null($loggedInUser);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="MotiV est une plateforme qui récompense les jeunes pour leurs efforts scolaires et sociaux, en les motivant à s'engager activement dans leur communauté.">
    <link rel="icon" type="image/x-icon" href="/asset/img/iconV.png">
    <link rel="stylesheet" href="/asset/css/style.css">
    <!-- icon Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title><?= ($titrePage) ?></title>
</head>

<body>
    <header>
        <!-- nom du site -->
        <div class="logo-points-container">
            <a href="/ctrl/home/display.php" class="logo-container">
                <h1>Moti<span>V</span></h1>
            </a>
            <!-- Affichage des points utilisateur sur mobile -->
            <?php if ($isLoggedIn && isset($loggedInUser['points']) && $loggedInUser['idRole'] == 60) : ?>
                <div class="points-display">
                    <i class="fas fa-star"></i>
                    <span><?= ($loggedInUser['points']) ?> Vpoints</span>
                </div>
            <?php endif; ?>
        </div>

        <!-- Menu burger pour mobile -->
        <div class="burger">
            <div></div>
            <div></div>
            <div></div>
        </div>

        <!-- Navigation principale -->
        <nav class="nav-principale">
            <ul>
                <li><a href="/ctrl/home/display.php"><i class="fas fa-home"></i><span>Accueil</span></a></li>
                <li><a href="/ctrl/mission/mission-list-public.php"><i class="fas fa-tasks"></i><span>Missions</span></a></li>
                <li><a href="/ctrl/reward/rewards.php"><i class="fas fa-gift"></i><span>Récompenses</span></a></li>
                <li><a href="/ctrl/cart/view-cart.php"><i class="fas fa-shopping-cart"></i><span>Mon Panier</span></a></li>

                <!-- Menu déroulant pour Acteurs -->
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropbtn"><span>Acteurs</span></a>
                    <div class="dropdown-content">
                        <a href="/ctrl/register/register-entity.php?role=partner">Partenaires</a>
                        <a href="/ctrl/register/register-entity.php?role=association">Associations</a>
                        <a href="/ctrl/professor/register-form.php">Professeurs</a>
                        <a href="/ctrl/contact/contact-display.php">Contact</a>
                    </div>
                </li>

                <!-- Informations utilisateur -->
                <li class="user-info">
                    <?php if ($isLoggedIn && isset($loggedInUser['points']) && $loggedInUser['idRole'] == 60) : ?>
                        <div class="points-display-destkop">
                            <i class="fas fa-star"></i>
                            <span><?= ($loggedInUser['points']) ?> Vpoints</span>
                        </div>
                    <?php endif; ?>
                </li>

                <!-- Avatar de l'utilisateur dans la barre de navigation mobile -->
                <?php if ($isLoggedIn) : ?>
                    <li><a href="<?= (getProfileLink($loggedInUser['idRole'])) ?>" class="image-avatar-nav">
                            <img class="image-avatar-nav" src="/upload/<?= ($loggedInUser['avatar_filename']) ?>" alt="Avatar">
                        </a></li>
                <?php else : ?>
                    <li><a href="/ctrl/login/login-display.php"><i class="fas fa-sign-in-alt"></i><span>Se connecter</span></a></li>
                <?php endif; ?>
            </ul>
        </nav>

        <!-- Menu pour mobile burger -->
        <nav class="menu-burger-hidden">
            <ul>
                <li><a href="/ctrl/register/register-entity.php?role=partner">Partenaires</a></li>
                <li><a href="/ctrl/register/register-entity.php?role=association">Associations</a></li>
                <li><a href="/ctrl/professor/register-form.php">Professeurs</a></li>
                <li><a href="/ctrl/contact/contact-display.php">Contact</a></li>
            </ul>
        </nav>
    </header>
    <!-- Script JS -->
    <script src="/asset/js/header.js"></script>
</body>
</html>
