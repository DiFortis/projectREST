<?php
// Rozpoczęcie sesji
session_start();

// Sprawdzenie, czy użytkownik jest już zalogowany, jeśli tak, to następuje przekierowanie go na stronę powitalną
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

// Uwzględnienie pliku połączeniowego z bazą
require_once "connect.php";

// Zdefiniowanie zmiennych i zainicjowanie ich z pustymi wartościami
$username = $password = "";
$username_err = $password_err = "";

// Przetwarzanie danych formularza po przesłaniu formularza
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sprawdzenie czy pole nazwy użytkownika jest puste
    if (empty(trim($_POST["username"]))) {
        $username_err = "Proszę wpisać nick.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Sprawdzenie czy pole hasła jest puste
    if (empty(trim($_POST["password"]))) {
        $password_err = "Proszę wpisać hasło.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Sprawdzenie wypełnionych pól
    if (empty($username_err) && empty($password_err)) {
        // Przygotowanie instrukcji SELECT
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Powiązanie zmiennych z przygotowaną instrukcją jako parametry
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Ustawienie parametrów
            $param_username = $username;

            // Próba wykonania przygotowanej instrukcji
            if (mysqli_stmt_execute($stmt)) {
                // Przechowanie wyniku
                mysqli_stmt_store_result($stmt);

                // Sprawdzenie, czy nazwa użytkownika istnieje, jeśli tak, to następuje sprawdzenie hasło
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Powiązanie zmiennych wynikowe
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Hasło jest poprawne, więc następuje rozpoczęcie nowej sesji
                            session_start();

                            // Przechowanie danych w zmiennych sesji
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Przekierowanie użytkownika na stronę powitalną
                            header("location: index.php");
                        } else {
                            // Wyświetlenie komunikatu o błędzie, jeśli hasło jest nieprawidłowe
                            $password_err = "Wprowadzone hasło jest nieprawidłowe.";
                        }
                    }
                } else {
                    // Wyświetlenie komunikatu o błędzie, jeśli nazwa użytkownika nie istnieje
                    $username_err = "Nie znaleziono konta z tą nazwą użytkownika.";
                }
            } else {
                echo "Ups! Coś poszło nie tak. Spróbuj ponownie później.";
            }
        }

        // Zakończenie instrukcji
        mysqli_stmt_close($stmt);
    }

    // Zakończenie połączenia
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
    <div class="wrapper" style="display: inline-block">
        <img src="img/brewapi.png" id="olbrew-login">
        <h2>Logowanie do Ol'Brew</h2>
        <p>Wypełnij poniższe pola aby się zalogować</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">

                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" placeholder="Nazwa użytkownika" required onfocus="this.placeholder=''" onblur="this.placeholder='Nazwa użytkownika'">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">

                <input type="password" name="password" class="form-control" placeholder="Hasło" required onfocus="this.placeholder=''" onblur="this.placeholder='Hasło'">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Zaloguj">
            </div>
            <p>Nie masz konta? <a href="register.php">Zarejestruj się teraz</a>.</p>
        </form>
    </div>
</body>

</html>