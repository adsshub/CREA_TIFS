<?php

$url = explode('index.php', $_SERVER['SCRIPT_NAME']);
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . str_replace(' ', '%20', $url[0]));