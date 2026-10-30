<?php

namespace App\Models\TagsModel;

use \PDO;

function findAll(PDO $connexion): array
{
    $sql = "SELECT *
            FROM tags
            ORDER BY id;";
    $rs = $connexion->query($sql);
    return $rs->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Les tags d'un projet 
 */
function findByProjectId(PDO $connexion, int $projectId): array
{
    $sql = "SELECT t.id, t.nom
            FROM tags t
            JOIN projets_has_tags pht ON pht.tag = t.id
            WHERE pht.projet = :id
            ORDER BY t.nom;";
    $rs = $connexion->prepare($sql);
    $rs->bindValue(':id', $projectId, PDO::PARAM_INT);
    $rs->execute();
    return $rs->fetchAll(PDO::FETCH_ASSOC);
}