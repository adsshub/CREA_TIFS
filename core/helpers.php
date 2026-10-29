<?php

namespace Core\Helpers;

/**
 * Transforme un texte en slug pour les URL (il n'y a pas de slug dans les tables).
 * Exemple : "Crête Flamant Rose" devient "crete-flamant-rose".
 */
function slugify(string $text): string
{
    // Tout en minuscules
    $slug = mb_strtolower($text, 'UTF-8');

    // Accents remplacés
    $slug = strtr($slug, [
        'é' => 'e', 'è' => 'e', 'ê' => 'e', 'à' => 'a', 'ç' => 'c', 'â' => 'a',
    ]);

    // Séparateurs remplacés par des tirets
    $slug = strtr($slug, [
        ' ' => '-', '.' => '-', '!' => '-', '?' => '-', "'" => '-', ';' => '-',
    ]);

    return $slug;
}

/**
 * Coupe un texte à l'espace juste avant le x-ième caractère et ajoute '...'.
 * Si le texte fait x caractères ou moins, il est renvoyé tel quel (sans '...').
 */
function truncate(string $text, int $length): string
{
    // Texte assez court : renvoyé tel quel
    if (mb_strlen($text, 'UTF-8') <= $length) {
        return $text;
    }

    // Les x premiers caractères sont gardés, puis coupés au dernier espace
    $cut = mb_substr($text, 0, $length, 'UTF-8');
    $lastSpace = mb_strrpos($cut, ' ', 0, 'UTF-8');
    if ($lastSpace !== false) {
        $cut = mb_substr($cut, 0, $lastSpace, 'UTF-8');
    }

    // Si le texte coupé finit par une ponctuation ( . , ; : ! ? ), elle est enlevée avant les '...'
    if (in_array(mb_substr($cut, -1, 1, 'UTF-8'), ['.', ',', ';', ':', '!', '?'], true)) {
        $cut = mb_substr($cut, 0, -1, 'UTF-8');
    }

    return $cut . '...';
}
