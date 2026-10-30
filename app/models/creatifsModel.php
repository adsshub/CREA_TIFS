<?php

namespace App\Models\CreatifsModel;

use \PDO;

function findAll(PDO $connexion): array
{
    $sql = "SELECT c.id, c.pseudo, c.image, COUNT(p.id) AS nbProjets
            FROM creatifs c
            LEFT JOIN projets p ON p.creatif = c.id
            GROUP BY c.id, c.pseudo, c.image
            ORDER BY c.id;";
    $rs = $connexion->query($sql);
    return $rs->fetchAll(PDO::FETCH_ASSOC);
}