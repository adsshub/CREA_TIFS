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