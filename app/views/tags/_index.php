<?php
// Je charge les tags dans $tags
include_once '../app/models/tagsModel.php';
$tags = \App\Models\TagsModel\findAll($connexion);
?>
<!-- Widget Tags -->
<div class="ct-side-card">
    <h5 class="ct-side-card__head">Tags</h5>
    <div class="ct-side-card__body">
        <ul class="ct-tags">
            <?php foreach ($tags as $tag) : ?>
                <li><a class="ct-tag" href="#"><?php echo $tag['nom']; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>