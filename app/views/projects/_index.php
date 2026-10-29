<!-- Cartes des projets (variable : $projects) -->
<?php foreach ($projects as $project) : ?>
    <!-- Lien vers le détail. PATTERN: /projects/id/slug.html -->
    <?php $link = BASE_URL . 'projects/' . $project['id'] . '/' . Core\Helpers\slugify($project['titre']) . '.html'; ?>
    <article class="ct-card">
        <div class="row">
            <div class="col-md-4">
                <a href="<?php echo $link; ?>">
                    <img class="img-fluid mb-3 mb-md-0" src="<?php echo BASE_URL; ?>images/<?php echo $project['image']; ?>" alt="<?php echo $project['titre']; ?>" />
                </a>
            </div>
            <div class="col-md-8">
                <h3><a href="<?php echo $link; ?>"><?php echo $project['titre']; ?></a></h3>
                <p class="ct-byline">
                    par <a href="#"><?php echo $project['creatif_pseudo']; ?></a>
                    · <?php echo date('d/m/Y', strtotime($project['dateCreation'])); ?>
                </p>
                <!-- Résumé tronqué à 100 caractères par truncate() -->
                <p><?php echo Core\Helpers\truncate((string) $project['resume'], SUMMARY_LENGTH); ?></p>
                <a class="ct-btn ct-btn--primary ct-btn--sm" href="<?php echo $link; ?>">Voir le projet</a>
            </div>
        </div>
    </article>
<?php endforeach; ?>
