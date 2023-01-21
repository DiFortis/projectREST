<?php
// Rozpocznij sesję
session_start();

// Sprawdzenie czy użytkownik jest zalogowany, jeśli nie to następuje przeniesienie go do strony logowania
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login.php");
  exit;
}
?>