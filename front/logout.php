<?php
// Rozpoczęcie sesji
session_start();

// Usunięcie wszystkich zmiennych sesyjnych
$_SESSION = array();

// Zniszczenie sesji
session_destroy();

// Przekierowanie do strony logowania
header("location: login.php");
exit;
