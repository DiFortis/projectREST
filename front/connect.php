<?php
/* Łączenie z bazą danych (MySQL) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'rest_project');

/* Próba połączenia z bazą MySQL */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Sprawdzenie połączenia
if($link === false){
    die("ERROR: Nie można połączyć z bazą. " . mysqli_connect_error());
}