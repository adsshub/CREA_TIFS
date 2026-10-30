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
