<!-- BANDEAU D'INTRO : zone $header (vide sauf sur la page d'accueil) -->
<?php echo $header; ?>

<!-- Avec bandeau : le contenu le chevauche (classe du template).
     Sans bandeau : marges du template (haut 2.5rem, et 3rem avant le footer). -->
<?php if (!$isform) : ?>
<div class="container ct-content-wrap">
<?php else : ?>
<div class="container" style="margin-top: 2.5rem; margin-bottom: 3rem">
<?php endif; ?>
    <div class="row">
        <!-- Colonne principale : zone dynamique $content (remplie par le contrôleur) -->
            <?php echo $content; ?>

        <!-- ASIDE : créa'tifs + tags, identique sur toutes les pages -->
         <!-- Colonne latérale -->
        <div class="col-lg-4">
            <?php include '../app/views/templates/partials/_aside.php'; ?>
        </div>
    </div>
</div>
