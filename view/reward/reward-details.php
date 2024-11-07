<main class="reward-details-container">
    <?php if (!empty($reward['image_filename'])) : ?>
        <img class="reward-details-image" src="/upload/<?= ($reward['image_filename']) ?>" alt="<?= ($reward['title']) ?>">
    <?php endif; ?>

    <section class="reward-details-info">
        <h1 class="reward-details-title"><?= ($reward['title']) ?></h1>
        <p class="reward-details-description"><strong>Description :</strong> <?= ($reward['description']) ?></p>
        <p class="reward-details-price"><strong>Prix :</strong> <?= ($reward['reward_price']) ?> points</p>
        <p class="reward-details-quantity"><strong>Quantité Disponible :</strong> <?= ($reward['quantity_available']) ?></p>
        <p class="reward-details-submitter"><strong>Proposé par :</strong> <?= ($reward['submitter_name']) ?></p>

        <?php if (!empty($reward['start_date_usage'])) : ?>
            <p class="reward-details-start-date"><strong>Date de début d'utilisation :</strong> <?= date('d/m/Y', strtotime($reward['start_date_usage'])) ?></p>
        <?php endif; ?>

        <?php if (!empty($reward['expiration_date'])) : ?>
            <p class="reward-details-expiration-date"><strong>Date limite d'utilisation :</strong> <?= date('d/m/Y', strtotime($reward['expiration_date'])) ?></p>
        <?php endif; ?>

        <?php if ($reward['quantity_available'] > 0) : ?>
            <?php if (isset($_SESSION['user']) && hasUserAlreadyRedeemed($_SESSION['user']['id'], $reward['id'], $dbConnection)) : ?>
                <p class="reward-details-redeemed"><strong>Vous avez déjà échangé cette récompense.</strong></p>
            <?php else : ?>
                <form action="/ctrl/cart/add-to-cart.php" method="POST" class="reward-details-form">
                    <input type="hidden" name="idReward" value="<?= ($reward['id']) ?>">
                    <button class="reward-details-button" type="submit">Ajouter au panier</button>
                </form>
                <?php if ($reward['idUser'] == $idUser) : ?>
                    <a class="reward-details-edit-link" href="/ctrl/reward/update-reward.php?id=<?= ($idReward) ?>">Modifier la récompense</a>
                <?php endif; ?>
            <?php endif; ?>
        <?php else : ?>
            <p class="reward-details-unavailable"><strong>Cette récompense n'est plus disponible.</strong></p>
        <?php endif; ?>
    </section>


    <!-- message -->
    <?php if (isset($_SESSION['success'])) : ?>
        <div class="reward-details-success-message">
            <?= $_SESSION['success'] ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])) : ?>
        <div class="reward-details-error-message">
            <?= $_SESSION['error'] ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <!-- Section des commentaires -->
    <section class="comments-section">
        <h3>Commentaires</h3>

        <?php if (isset($_SESSION['user'])) : ?>
            <form action="/ctrl/reward/reward-details.php?idReward=<?= ($idReward) ?>" method="POST">
                <textarea name="comment" rows="4" cols="50" placeholder="Écrivez votre commentaire ici..." required></textarea><br>
                <button type="submit" class="button-comment">Commenter</button>
            </form>
        <?php else : ?>
            <p><a href="/ctrl/login/login-display.php">Connectez-vous</a> pour écrire un commentaire.</p>
        <?php endif; ?>

        <!-- Affichage des commentaires -->
        <?php if (!empty($comments)) : ?>
            <?php foreach ($comments as $comment) : ?>
                <div class="comment">
                    <p><strong><?= ($comment['author_name']) ?></strong> - <?= date('d/m/Y H:i', strtotime($comment['date'])) ?></p>
                    <p><?= ($comment['text']) ?></p>

                    <!-- L'utilisateur peut modifier ses commentaires et l'admin peut supprimer -->
                    <?php if (isset($_SESSION['user'])) : ?>
                        <?php if ($_SESSION['user']['id'] == $comment['idUser']) : ?>
                            <a id="edit-link-comment-<?= ($comment['id']) ?>" href="#" onclick="showEditForm(<?= ($comment['id']) ?>)">Modifier</a>
                            <a id="delete-link-comment-<?= ($comment['id']) ?>" href="/ctrl/reward/reward-details.php?delete=<?= ($comment['id']) ?>&idReward=<?= ($idReward) ?>">Supprimer</a>

                            <!-- Formulaire de modification du commentaire -->
                            <div id="edit-form-<?= ($comment['id']) ?>" class="edit-comment-form" style="display:none;">
                                <form action="/ctrl/reward/reward-details.php?idReward=<?= ($idReward) ?>" method="POST">
                                    <textarea name="editComment" required><?= ($comment['text']) ?></textarea>
                                    <input type="hidden" name="editCommentId" value="<?= ($comment['id']) ?>">
                                    <button type="submit" class="button-comment">Modifier</button>
                                    <button type="button" onclick="hideEditForm(<?= ($comment['id']) ?>)">Annuler</button>
                                </form>
                            </div>
                        <?php elseif ($_SESSION['user']['idRole'] == 10) : ?>
                            <a href="/ctrl/reward/reward-details.php?delete=<?= ($comment['id']) ?>&idReward=<?= ($idReward) ?>">Supprimer</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>Aucun commentaire pour le moment.</p>
        <?php endif; ?>
    </section>
</main>

<script src="/asset/js/comment.js"></script>