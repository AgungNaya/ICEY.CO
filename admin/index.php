<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <dic class="row min-vh-100 justify-content-center align-items-center">
            <div class="col-4">
                <?php
                    if(isset($_GET['auth']) && $_GET['auth'] == 'false') {
                        ?>
                        <div class="alert alert-danger mb-3" role="alert">
                            Username dan/atau Password anda salah!
                        </div>
                    <?php
                    }
                    if(isset($_GET['auth']) && $_GET['auth'] == 'forbidden') {
                        ?>
                        <div class="alert alert-danger mb-3" role="alert">
                           Anda tidak diizinkan mengakses halaman admin!
                        </div> 
                    <?php
                    }
                    if(isset($_GET['auth']) && $_GET['auth'] == 'logout') {
                        ?>
                        <div class="alert alert-danger mb-3" role="alert">
                           Anda berhasil logout!
                        </div> 
                    <?php
                    }
                    ?>  
                    
                <div class="card">
                    <div class="card-header text-center">
                        Login
                    </div>
                    <div class="card-body">
                        <form action="proses.login.php" method="post">
                            <div class= "mb-3">
                                <input type="text" name="username" placeholder="Username" class="form-control">
                            </div>
                            <div class= "mb-3">
                                <input type="password" name="password" placeholder="Password" class="form-control">
                            </div>
                            <div class="d-grid gap-2">
                                <button class="btn btn-info" type="submit">Login</button>
                            </div>
                        </form>
                    </div>  
                </div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>  
</body>
</html>