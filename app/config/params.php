<?php
// PARAMS
$title = "CREA'TIFS";
$content = "";
$header = "";

// Paramètres de connexion à la DB
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '8889');
define('DB_NAME', 'creatifs');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');

// Pagination : 10 projets par page, résumé tronqué à 100 caractères
define('PER_PAGE', 10);
define('SUMMARY_LENGTH', 100);