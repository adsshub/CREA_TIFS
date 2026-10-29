<!-- BANDEAU D'INTRO : zone $header (vide sauf sur la page d'accueil) -->
<?php echo $header; ?>

<!-- Avec bandeau : le contenu le chevauche (classe du template).
     Sans bandeau : marges du template (haut 2.5rem, et 3rem avant le footer). -->
<div class="container ct-content-wrap">
    <div class="row">
        <!-- Colonne principale : zone dynamique $content (remplie par le contrôleur) -->
        <div class="col-lg-8">
            <?php echo $content; ?>
        </div>

        <!-- ASIDE : créa'tifs + tags, identique sur toutes les pages -->
            <?php include '../app/views/templates/partials/_aside.php'; ?>
    </div>
</div>
