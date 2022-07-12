<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial=scale-1">
        <title>Memes</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    </head>
    <body class="text-white" style="background-color:rgb(25,25,25);">

        <!-- Navbar -->
        <nav class="navbar navbar-dark p-2 navbar-expand-lg" style="background-color:rgb(15,15,15);">
            <div class="container">
                <a class="bi bi-tsunami navbar-brand" href="index.php"> Memes</a>
                <div class="d-flex">
                <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="#" class="nav-link">Pending</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Random</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Categories
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Fun</a></li>
                                <li><a class="dropdown-item" href="#">Animals</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
</div>
            </div>
        </nav>

        <div class="container">
            <div class="row">
                <!-- left -->
                <div class="col-md-8">
                    <div class="container">
                        <div class="container p-5">
                            <div class="container d-flex p-0"  style="background-color:rgb(15,15,15);">
                                <img src="profile.png" width="50" alt="profile-pic">
                                <p class="m-2">Tytul</p>
                                <!-- <p class="text-end">1</p> -->
                            </div>
                            <p class="px-3 py-1 mt-2 mb-0" style="background-color:rgb(15,15,15);">Data Categoria</p>
                            <img src="pepe.jpeg" width="100%" alt="meme">
                        </div>
                    </div>
                </div>

                <!-- right -->
                <div class="col-md-4 p-5">
                    <div class="container p-4"  style="background-color:rgb(50,50,50);">
                        <form action="">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control bg-dark border-dark" placeholder="Enter username or email">
                            </div>
                            <div class="input-group mb-2">
                                <input type="password" class="form-control bg-dark border-dark" placeholder="Password">
                            </div>
                            <div class="input-group mb-2">
                                <input type="submit" class="btn btn-danger form-control" value="Login">
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md">Forgot password</div>
                            <div class="col-md text-end">Register</div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap JS Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>