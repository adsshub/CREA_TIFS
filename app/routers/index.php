<?php
// ROUTEUR PRINCIPAL

// ROUTE PAR DÉFAUT : LISTE DES PROJETS
// PATTERN: /
// CTRL: ProjectsController
// ACTION: indexAction
include_once '../app/controllers/projectsController.php';
\App\Controllers\ProjectsController\indexAction($connexion);


