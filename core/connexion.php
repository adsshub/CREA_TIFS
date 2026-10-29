<?php
// Connexion

try {
    $connexion = new PDO(
        'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD
    );
} catch (PDOException $e) {
    echo $e;
}