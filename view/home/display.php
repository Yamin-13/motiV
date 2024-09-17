<main class="home-page">
    <!-- Section Héros -->
    <section class="hero">
        <div class="hero-content">
            <h2 class="home-title">Gagne des récompenses en faisant la différence</h2>
            <p>Engage-toi dans des missions, accumule des points, et sois récompensé pour ton engagement.</p>
            <a href="/ctrl/register/register.php" class="cta-button">Rejoins-nous</a>
        </div>
    </section>

    <!-- Présentation brève avec un scroll reveal -->
    <section class="about scroll-reveal">
        <h2>Qu'est-ce que MotiV&nbsp;?</h2>
        <p>MotiV est une plateforme qui valorise tes efforts scolaires et ton engagement citoyen. Accumule des points en participant à des missions et échange-les contre des récompenses offertes par nos partenaires.</p>
    </section>

    <!-- Étape pour savoir comment ca marche avec un scroll reveal -->
    <section class="steps scroll-reveal">
        <h2>Comment ça marche&nbsp;?</h2>
        <div class="steps-container">
            <div class="step">
                <i class="fas fa-user-plus"></i>
                <h3>1. Inscris-toi</h3>
                <p>Crée ton compte gratuitement en quelques clics.</p>
            </div>
            <div class="step">
                <i class="fas fa-tasks"></i>
                <h3>2. Participe</h3>
                <p>Accomplis des missions et engage-toi dans ta communauté.</p>
            </div>
            <div class="step">
                <i class="fas fa-gift"></i>
                <h3>3. Sois récompensé</h3>
                <p>Échange tes points contre des cadeaux et des avantages.</p>
            </div>
        </div>
    </section>

    <!-- Carrousel des récompenses -->
    <section class="rewards scroll-reveal">
        <h2>Récompenses à découvrir</h2>
        <div class="carousel-container">
            <div class="carousel" id="rewards-carousel">
                <?php if (!empty($randomRewards)) : ?>
                    <?php foreach ($randomRewards as $reward) : ?>
                        <div class="carousel-item" onclick="window.location.href='/ctrl/reward/reward-details.php?idReward=<?= ($reward['id']) ?>'">
                            <?php if (!empty($reward['image_filename'])) : ?>
                                <img src="/upload/<?= ($reward['image_filename']) ?>" alt="<?= ($reward['title']) ?>">
                            <?php else : ?>
                                <img src="/upload/default-reward.jpg" alt="Récompense par défaut">
                            <?php endif; ?>
                            <h3><?= ($reward['title']) ?></h3>
                            <p><strong>Prix :</strong> <?= ($reward['reward_price']) ?> points</p>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>Aucune récompense à afficher pour le moment.</p>
                <?php endif; ?>
            </div>
            
            <!-- Flèche de navigation des récompenses-->
            <button class="carousel-btn prev" id="rewards-prev"><i class="fas fa-chevron-left"></i></button>
            <button class="carousel-btn next" id="rewards-next"><i class="fas fa-chevron-right"></i></button>
        </div>
        <a href="/ctrl/reward/rewards.php" class="cta-button-rewards">Voir toutes les Récompense</a>
    </section>

    <!-- Carrousel des missions -->
    <section class="missions scroll-reveal">
        <h2>Les dernières missions</h2>
        <div class="carousel-container">
            <div class="carousel" id="missions-carousel">
                <?php if (!empty($latestMissions)) : ?>
                    <?php foreach ($latestMissions as $mission) : ?>
                        <div class="carousel-item">
                            <?php if (!empty($mission['image_filename'])) : ?>
                                <img src="/upload/<?= ($mission['image_filename']) ?>" alt="<?= ($mission['title']) ?>">
                            <?php else : ?>
                                <img src="/upload/default-mission.jpg" alt="Mission par défaut">
                            <?php endif; ?>
                            <h3><?= ($mission['title']) ?></h3>
                            <p><strong>Points :</strong> <?= ($mission['point_award']) ?></p>
                            <a href="/ctrl/mission/details-mission.php?id=<?= ($mission['id']) ?>" class="cta-button">Détails</a>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>Aucune mission disponible pour le moment.</p>
                <?php endif; ?>
            </div>
            <!-- flèche de navigation des missions -->
            <button class="carousel-btn prev" id="missions-prev"><i class="fas fa-chevron-left"></i></button>
            <button class="carousel-btn next" id="missions-next"><i class="fas fa-chevron-right"></i></button>
        </div>
        <a href="/ctrl/mission/mission-list-public.php" class="cta-button-mission">Voir toutes les missions</a>
    </section>

    <!-- Témoignage avec un Scroll Reveal -->
    <section class="testimonials scroll-reveal">
        <h2>Ils parlent de nous</h2>
        <div class="testimonials-container">
            <div class="testimonial">
                <p>"Grâce à MotiV, je me suis impliqué dans ma communauté et j'ai pu échanger mes points contre des places de cinéma&nbsp;!"</p>
                <h4>- Lucas, 16 ans</h4>
            </div>
            <div class="testimonial">
                <p>"Cette plateforme m'a motivée à améliorer mes notes et à aider les autres."</p>
                <h4>- Sarah, 14 ans</h4>
            </div>
        </div>
    </section>

    <!-- Partenaires avec un défilement continu -->
    <section class="partners scroll-reveal">
        <h2>Ta Moti'V,Tes partenaires</h2>
        <div class="scroll-container">
            <div class="partners-container scroll-content">
                <img src="/asset/img/logo-ville-de-marseille.webp" alt="Ville de Marseille">
                <img src="/asset/img/unisCitéLogo.png" alt="Unis Cité">
                <img src="/asset/img/region-sud-logo.webp" alt="Région sud PACA">
                <img src="/asset/img/fondationDeMarseilleLogo.webp" alt="Fondation de Marseille">
                <img src="/asset/img/apprentisDauteuil.png" alt="Apprentis d'Auteuil">
                <img src="/asset/img/marseilleSolution.webp" alt="Marseille Solutions">
            </div>
        </div>
    </section>

    <!-- Appel à l'Action -->
    <section class="call-to-action">
        <h2>Prêt à commencer ton aventure&nbsp;?</h2>
        <a href="/ctrl/register/register.php" class="cta-button">Inscris-toi dès maintenant</a>
    </section>
</main>

<!-- inclusion des scripts JS -->
<script src="/asset/js/scrollreveal.js"></script>
<script src="/asset/js/caroussel.js"></script>
<script src="/asset/js/home.js"></script>