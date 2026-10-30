<?php

use App\Controllers\ProjectsController;

include_once '../app/controllers/projectsController.php';

// Le paramètre ?projects=xxx est ajouté par public/.htaccess : il indique l'action à appeler.
// Le numéro du projet arrive dans ?id=x.
switch ($_GET['projects']):

    // DÉTAIL D'UN PROJET
    // PATTERN: /projects/id/slug.html
    // CTRL: ProjectsController
    // ACTION: showAction
    case 'show':
        ProjectsController\showAction($connexion, $_GET['id']);
        break;

    // SUPPRESSION D'UN PROJET (puis redirection vers l'accueil)
    // PATTERN: /projects/delete/id/slug.html
    // CTRL: ProjectsController
    // ACTION: deleteAction
    case 'delete':
        ProjectsController\deleteAction($connexion, $_GET['id']);
        break;

    // AJOUT : FORMULAIRE
    // PATTERN: /projects/add/form.html
    // CTRL: ProjectsController
    // ACTION: addFormAction
    case 'addForm':
        ProjectsController\addFormAction($connexion);
        break;

    // AJOUT : ENREGISTREMENT (puis redirection vers l'accueil)
    // PATTERN: /projects/add/insert.html   (méthode POST)
    // CTRL: ProjectsController
    // ACTION: addInsertAction
    case 'addInsert':
        ProjectsController\addInsertAction($connexion, $_POST);
        break;

    // MODIFICATION : FORMULAIRE
    // PATTERN: /projects/id/slug/edit/form.html
    // CTRL: ProjectsController
    // ACTION: editFormAction
    case 'editForm':
        ProjectsController\editFormAction($connexion, $_GET['id']);
        break;

    // MODIFICATION : ENREGISTREMENT (puis redirection vers l'accueil)
    // PATTERN: /projects/id/slug/edit/update.html   (méthode POST)
    // CTRL: ProjectsController
    // ACTION: editUpdateAction
    case 'editUpdate':
        ProjectsController\editUpdateAction($connexion, $_GET['id'], $_POST);
        break;

// ROUTE PAR DÉFAUT : LISTE DES PROJETS
    // PATTERN: /projects      (page suivante : /projects?page=2)
    // CTRL: ProjectsController
    // ACTION: indexAction
    default:
        ProjectsController\indexAction($connexion);
        break;
endswitch;