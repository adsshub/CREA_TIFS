<?php

// ROUTES DES PROJETS
// PATTERN COMMUN: /projects/xxx
// (réécrit par public/.htaccess en ?projects=xxx)
if (isset($_GET['projects']) && $_GET['projects'] === 'show') :
    include_once '../app/controllers/projectsController.php';
    \App\Controllers\ProjectsController\showAction($connexion, (int)$_GET['id']);


// ROUTE PAR DÉFAUT : LISTE DES PROJETS
// PATTERN: /
// CTRL: ProjectsController
// ACTION: indexAction
else :
    include_once '../app/controllers/projectsController.php';
    \App\Controllers\ProjectsController\indexAction($connexion);
endif;