<?php

namespace App\Controllers\ProjectsController;

use \PDO;
use \App\Models\ProjectsModel;
use \App\Models\TagsModel;

function indexAction(PDO $connexion): void
{
    include_once '../app/models/projectsModel.php';

    // Nombre de pages = nombre de projets / 10, arrondi vers le haut
    $totalPages = max(1, (int) ceil(ProjectsModel\countAll($connexion) / PER_PAGE));

    // Page demandée (?page=2), gardée entre 1 et la dernière page
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $page = min(max($page, 1), $totalPages);

    // Je charge les projets de cette page dans $projects
    $projects = ProjectsModel\findAll($connexion, PER_PAGE, ($page - 1) * PER_PAGE);

    global $header, $content;

    // 1. Je charge le bandeau d'intro dans $header (seulement sur l'accueil)
    ob_start();
    include '../app/views/templates/partials/_header.php';
    $header = ob_get_clean();

    // 2. Je charge projects.index dans $content
    ob_start();
    include '../app/views/projects/index.php';
    $content = ob_get_clean();
}

function showAction(PDO $connexion, int $id): void
{
    include_once '../app/models/projectsModel.php';
    include_once '../app/models/tagsModel.php';

    // On force l'ID en entier pour correspondre au modèle
    $project = ProjectsModel\findOneById($connexion, $id);
    $projectTags = TagsModel\findByProjectId($connexion, $id);

    global $title, $content;
    $title = $project['titre'] . " — " . $title;
    ob_start();
    include '../app/views/projects/show.php';
    $content = ob_get_clean();
}

function deleteAction(PDO $connexion, int $id): void
{
    include_once '../app/models/projectsModel.php';

    ProjectsModel\deleteOneById($connexion, $id);

    // Redirection vers la page d'accueil
    header('Location: ' . BASE_URL);
    exit;
}
