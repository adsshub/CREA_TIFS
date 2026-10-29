<!-- Pagination (variables : $page = page courante, $totalPages)
     Les liens utilisent la route /projects avec ?page=N -->
<nav aria-label="Navigation entre les pages de projets">
    <ul class="pagination ct-pagination" style="justify-content: center">
        <li class="page-item<?php echo $page <= 1 ? ' disabled' : ''; ?>">
            <a class="page-link" href="<?php echo BASE_URL; ?>projects?page=<?php echo max(1, $page - 1); ?>">Précédent</a>
        </li>

        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
            <li class="page-item<?php echo $i === $page ? ' active' : ''; ?>">
                <a class="page-link" href="<?php echo BASE_URL; ?>projects?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>

        <li class="page-item<?php echo $page >= $totalPages ? ' disabled' : ''; ?>">
            <a class="page-link" href="<?php echo BASE_URL; ?>projects?page=<?php echo min($totalPages, $page + 1); ?>">Suivant</a>
        </li>
    </ul>
</nav>
