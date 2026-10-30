<!-- Détail d'un projet (variables : $project, $projectTags) -->
<section>
    <?php $slug = Core\Helpers\slugify($project['titre']); ?>
    <h1><?php echo $project['titre']; ?></h1>
    <p class="ct-byline">
        par <a href="#"><?php echo $project['creatif_pseudo']; ?></a>
        · <?php echo date('d/m/Y', strtotime($project['dateCreation'])); ?>
    </p>

    <div class="mb-4">
        <!-- PATTERN: /projects/id/slug/edit/form.html -->
        <a href="<?php echo BASE_URL; ?>projects/<?php echo $project['id']; ?>/<?php echo $slug; ?>/edit/form.html" class="ct-btn ct-btn--primary">Éditer le projet</a>
        <!-- PATTERN: /projects/delete/id/slug.html -->
        <a
            href="<?php echo BASE_URL; ?>projects/delete/<?php echo $project['id']; ?>/<?php echo $slug; ?>.html"
            class="ct-btn ct-btn--danger"
            onclick="return confirm('Supprimer définitivement ce projet ?');">Supprimer le projet</a>
    </div>

    <article class="ct-card">
        <div class="row">
            <div class="col-md-6">
                <img class="img-fluid mb-3 mb-md-0" src="<?php echo BASE_URL; ?>images/<?php echo $project['image']; ?>" alt="<?php echo $project['titre']; ?>" />
            </div>
            <div class="col-md-6">
                <p class="lead" style="font-weight: 600"><?php echo $project['resume']; ?></p>
                <hr />
                <p><?php echo $project['texte']; ?></p>
                <hr />
                <ul class="ct-tags">
                    <?php foreach ($projectTags as $tag) : ?>
                        <li><a class="ct-tag" href="#"><?php echo $tag['nom']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </article>
</section>