<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICEY.CO</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@900&family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../admin/style.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
  
</head>
<body class="pengguna-body">
<div class="container">
  <div class="row">
    <div class="col-12">
      <nav class="navbar navbar-expand-lg navbar-light bg-beige fixed-top">
        <div class="container">
          <a class="navbar-brand" href="#"><span class="text-info">ICEY</span>.co</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="about.php">About Us</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="produk.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Ice Cream
                </a>
                <ul class="dropdown-menu">
                  <?php 
                    require_once '../include/koneksi.php';
                    $sql = 'SELECT * FROM kategori';
                    $query = mysqli_query($connection, $sql);
                    while($result = mysqli_fetch_assoc($query)) {
                      echo ' <li><a class="dropdown-item" href="produk.php?kategori='.$result['id'].'">'.$result['kategori'].'</a></li>';
                    }
                  
                  ?>
                </ul>
                </li>
              <li class="nav-item">
                <a class="nav-link" href="../admin/index.php">Login</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </div>
</div>
