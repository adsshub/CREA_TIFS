<?php

// ROUTES DES PROJETS
// PATTERN COMMUN: /projects/xxx
// (réécrit par public/.htaccess en ?projects=xxx)
if (isset($_GET['projects'])) :
    include_once '../app/routers/projects.php';

// ROUTE PAR DÉFAUT : LISTE DES PROJETS
// PATTERN: /
// CTRL: ProjectsController
// ACTION: indexAction
else :
    include_once '../app/controllers/projectsController.php';
    \App\Controllers\ProjectsController\indexAction($connexion);
endif;
