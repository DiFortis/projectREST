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
            </div>
        </div>
    </header>
    <div class="wrapper" style="display: inline-block">
        <img src="img/brewapi.png" id="olbrew-login"></img>
        <h2>Update a beverage</h2>
        <p>Fill in all fields to update beverage info</p>
        <form action="">
            <div class="form-group">

                <input type="text" name="name" class="form-control" value="" placeholder="Name" required onfocus="this.placeholder=''" onblur="this.placeholder='Name'">
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <input type="text" name="ingredients" class="form-control" placeholder="Ingredients" required onfocus="this.placeholder=''" onblur="this.placeholder='Ingredients'">
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <input type="bool" name="is_available" class="form-control" value="" placeholder="Available?(0 or 1)" required onfocus="this.placeholder=''" onblur="this.placeholder='Available?(0 or 1)'">
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Update beverage">
            </div>
        </form>
    </div>
</body>

</html>