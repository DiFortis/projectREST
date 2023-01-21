<?php
// Rozpoczęcie sesji
session_start();

// Sprawdzenie czy użytkownik jest zalogowany, jeśli nie to następuje przeniesienie do strony logowania
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Uwzględnienie pliku połączeniowego z bazą
require_once "connect.php";

// Zdefiniowanie zmiennych i zainicjowanie ich z pustymi wartościami
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

// Przetwarzanie danych formularza po przesłaniu formularza
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sprawdzenie poprawności nowego hasła
    if (empty(trim($_POST["new_password"]))) {
        $new_password_err = "Enter new password.";
    } elseif (strlen(trim($_POST["new_password"])) < 6) {
        $new_password_err = "Password must contain at least6 characters.";
    } else {
        $new_password = trim($_POST["new_password"]);
    }

    // Sprawdzenie poprawności potwierdzenia hasła
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Confirm password";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($new_password_err) && ($new_password != $confirm_password)) {
            $confirm_password_err = "Passwords don't match";
        }
    }

    // Sprawdzenie błędów wejściowych przed aktualizacją bazy danych
    if (empty($new_password_err) && empty($confirm_password_err)) {
        // Przygotowanie instrukcji UPDATE
        $sql = "UPDATE users SET password = ? WHERE id = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Powiązanie zmiennych z przygotowaną instrukcją jako parametry
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);

            // Ustawienie parametrów
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];

            // Próba wykonania przygotowanej instrukcji
            if (mysqli_stmt_execute($stmt)) {
                // Hasło zostało zmienione. Zniszcz sesję i przekieruj do strony logowania
                session_destroy();
                header("location: login.php");
                exit();
            } else {
                echo "Oops! Something has gone wrong. Try again later.";
            }
        }

        // Zakończ instrukcję
        mysqli_stmt_close($stmt);
    }

    // Zakończ połączenie
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Zresetuj hasło</title>
    <meta charset="UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <link href="styles/stylesheetlogowania.css" rel="stylesheet">
</head>

<body>
<header class="p-3 text-bg-dark">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a class="navbar-brand">
                    <img src="img/brewapi.png" alt="" width="40" height="50" class="d-inline-block ">
                    BrewAPI
                </a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="index.php" class="nav-link px-2 text-white">Home</a></li>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle px-2 text-white" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Products
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                                <li><a class="dropdown-item" href="index.php" style="text-decoration: none">View</a></li>
                                <li><a class="dropdown-item" href="add.php" style="text-decoration: none">Add</a></li>
                                <li><a class="dropdown-item" href="update.php" style="text-decoration: none">Update</a></li>
                                <li><a class="dropdown-item" href="delete.php" style="text-decoration: none">Delete</a></li>
                            </ul>
                        </li>
                    </ul>
                </ul>
                <?php if (isset($_SESSION['username'])) : ?>
                <div class="text-end">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user fa-xl"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                                <li><a class="dropdown-item" href="account.php" style="text-decoration: none"><span class="glyphicon glyphicon-user"></span> <b class="b-user">Profil: <?php echo htmlspecialchars($_SESSION["username"]); ?></b></a></li>
                                <li><a class="dropdown-item" href="pass_reset.php" style="text-decoration: none" id="a-log-out"><span class="glyphicon glyphicon-log-out"></span> Reset password</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="logout.php" style="text-decoration: none" id="a-log-out"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <?php endif ?>
            </div>
        </div>
    </header>
    <div class="wrapper">
        <h2>Reset your password</h2>
        <p>Please fill in fields below to reset your password</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">

                <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>" placeholder="new password" required onfocus="this.placeholder=''" onblur="this.placeholder='new password'">
                <span class="help-block"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">

                <input type="password" name="confirm_password" class="form-control" placeholder="Potwierdź hasło" required onfocus="this.placeholder=''" onblur="this.placeholder='Potwierdź hasło'">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Zresetuj hasło">
                <a class="btn btn-default" href="account.php">Anuluj</a>
            </div>
        </form>
    </div>
</body>

</html>