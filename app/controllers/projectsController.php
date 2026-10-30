<?php

namespace App\Controllers\ProjectsController;

use \PDO;
use \App\Models\ProjectsModel;
use \App\Models\TagsModel;
use \App\Models\CreatifsModel;

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

/**
 * Supprime le projet puis redirige vers l'accueil.
 * PATTERN: /projects/delete/id/slug.html
 */
function deleteAction(PDO $connexion, int $id): void
{
    include_once '../app/models/projectsModel.php';

    ProjectsModel\deleteOneById($connexion, $id);

    // Redirection vers la page d'accueil
    header('Location: ' . BASE_URL);
    exit;
}

/**
 * Formulaire d'ajout, avec les champs vides.
 * PATTERN: /projects/add/form.html
 */
function addFormAction(PDO $connexion): void
{
    include_once '../app/models/creatifsModel.php';
    include_once '../app/models/tagsModel.php';

    
    $project = ['titre' => '', 'resume' => '', 'texte' => '', 'creatif' => 0];
    $projectTagIds = [];

    // Créa'tifs (liste déroulante) et tags (cases à cocher) du formulaire
    $creatifs = CreatifsModel\findAll($connexion);
    $tags = TagsModel\findAll($connexion);

    $formAction = BASE_URL . 'projects/add/insert.html';

    $formTitle = 'Ajouter un projet';

    global $title, $content, $isform;
    $title = $formTitle . " — " . $title;
    $isform = true;
    ob_start();
    include '../app/views/projects/form.php';
    $content = ob_get_clean();
}

/**
 * Ajoute le projet dans la base puis redirige vers l'accueil.
 * PATTERN: /projects/add/insert.html (méthode POST)
 */
function addInsertAction(PDO $connexion, array $post): void
{
    include_once '../app/models/projectsModel.php';

    $data = readForm($post);
    $data['image'] = uploadImage();
    ProjectsModel\insertOne($connexion, $data);

    // Redirection vers la page d'accueil
    header('Location: ' . BASE_URL);
    exit;
}

/**
 * Formulaire de modification, avec les champs remplis par le projet.
 * PATTERN: /projects/id/slug/edit/form.html
 */
function editFormAction(PDO $connexion, string $id): void
{
    include_once '../app/models/projectsModel.php';
    include_once '../app/models/creatifsModel.php';
    include_once '../app/models/tagsModel.php';

    // Projet à modifier, pour remplir les champs du formulaire
    $project = ProjectsModel\findOneById($connexion, $id);

    // Numéros des tags déjà cochés
    $projectTagIds = array_column(TagsModel\findByProjectId($connexion, $id), 'id');

    // Créa'tifs (liste déroulante) et tags (cases à cocher) du formulaire
    $creatifs = CreatifsModel\findAll($connexion);
    $tags = TagsModel\findAll($connexion);

    $formAction = BASE_URL . 'projects/' . $id . '/' . \Core\Helpers\slugify($project['titre']) . '/edit/update.html';

    $formTitle = 'Modifier le projet';

    global $title, $content, $isForm;
    $title = $formTitle . " — " . $title;
    $isForm = true;
    ob_start();
    include '../app/views/projects/form.php';
    $content = ob_get_clean();
}

/* ---------- FONCTIONS INTERNES (pas des routes) ---------- */

function readForm(array $post): array
{
    return [
        'titre'   => $post['title'],
        'resume'  => $post['resume'],
        'texte'   => $post['text'],
        'creatif' => (int) $post['category_id'],
        'tags'    => array_map('intval', $post['tags'] ?? []),   // numéros des tags cochés
    ];
}

function uploadImage(): ?string
{
    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $extension;

    move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . $filename);

    return $filename;
}
