<?php

namespace App\Models\ProjectsModel;

use \PDO;

/**
 * Nombre total de projets (pour calculer le nombre de pages).
 */
function countAll(PDO $connexion): int
{
    $sql = "SELECT COUNT(*)
            FROM projets;";
    $rs = $connexion->query($sql);
    return (int) $rs->fetchColumn();
}

/**
 * Les projets d'une page, du plus récent au plus ancien, avec le pseudo du créa'tif.
 * $offset = le nombre de projets à sauter (ceux des pages précédentes).
 */
function findAll(PDO $connexion, int $limit, int $offset): array
{
    $sql = "SELECT p.id, p.titre, p.resume, p.dateCreation, p.image,
                   c.pseudo AS creatif_pseudo
            FROM projets p
            JOIN creatifs c ON p.creatif = c.id
            ORDER BY p.dateCreation DESC, p.id DESC
            LIMIT :limit OFFSET :offset;";
    $rs = $connexion->prepare($sql);
    $rs->bindValue(':limit', $limit, PDO::PARAM_INT);
    $rs->bindValue(':offset', $offset, PDO::PARAM_INT);
    $rs->execute();
    return $rs->fetchAll(PDO::FETCH_ASSOC);
}

function findOneById(PDO $connexion, int $id): ?array
{
    $sql = "SELECT p.*, c.pseudo AS creatif_pseudo
            FROM projets p
            JOIN creatifs c ON p.creatif = c.id
            WHERE p.id = :id;";
    $rs = $connexion->prepare($sql);
    $rs->bindValue(':id', $id, PDO::PARAM_INT);
    $rs->execute();
    return $rs->fetch(PDO::FETCH_ASSOC) ?: null;
}

function deleteOneById(PDO $connexion, int $id): void
{
    $sql = "DELETE 
            FROM projets_has_tags 
            WHERE projet = :id;";
    $rs = $connexion->prepare($sql);
    $rs->execute([':id' => $id]);

    $sql = "DELETE 
            FROM projets 
            WHERE id = :id;";
    $rs = $connexion->prepare($sql);
    $rs->execute([':id' => $id]);
}

function insertOne(PDO $connexion, array $data): int
{
    // 1. Requête d'insertion avec SET
    $sql = "INSERT INTO projets 
            SET titre         = :titre, 
                resume        = :resume, 
                texte         = :texte, 
                dateCreation  = NOW(), 
                image         = :image, 
                creatif       = :creatif;";
                
    $rs = $connexion->prepare($sql);
    
    // 2. Association des valeurs avec bindValue
    $rs->bindValue(':titre',   $data['titre'],   PDO::PARAM_STR);
    $rs->bindValue(':resume',  $data['resume'],  PDO::PARAM_STR);
    $rs->bindValue(':texte',   $data['texte'],   PDO::PARAM_STR);
    $rs->bindValue(':image',   $data['image'],   PDO::PARAM_STR);
    $rs->bindValue(':creatif', $data['creatif'], PDO::PARAM_INT);
    
    $rs->execute();

    // 3. Récupération de l'ID et enregistrement des tags
    $id = (int) $connexion->lastInsertId();
    saveTags($connexion, $id, $data['tags']);
    
    return $id;
}

function saveTags(PDO $connexion, int $projectId, array $tagIds): void
{
    $sql = "DELETE 
            FROM projets_has_tags 
            WHERE projet = :id;";
    $rs = $connexion->prepare($sql);
    $rs->execute([':id' => $projectId]);

    $sql = "INSERT 
            INTO projets_has_tags (projet, tag) 
            VALUES (:projet, :tag);";
    $rs = $connexion->prepare($sql);
    foreach ($tagIds as $tagId) {
        $rs->execute([':projet' => $projectId, ':tag' => $tagId]);
    }
}