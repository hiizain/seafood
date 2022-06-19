<?php
session_start();

// if ( isset($_SESSION["login"]) ){
//   header("Location: user/toko.php");
// }

require 'functions.php';
    if (isset($_POST["submit"])){
        if (login($_POST)==="1"){
            // var_dump(login($_POST));
            // exit;
            $_SESSION["login"] = true;
            $_SESSION["email"] = $_POST["email"];
            header("Location: admin/index.php");
        } else if(login($_POST)==="2"){
            $_SESSION["login"] = true;
            $_SESSION["email"] = $_POST["email"];
            header("Location: user/toko.php");
        }
        else {
            echo "
                <script>
                    alert('Login gagal');
                    document.location.href = 'login.php'
                </script>
            ";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Inner Page - Vesperr Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets_LP/img/favicon.png" rel="icon">
  <link href="assets_LP/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets_LP/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets_LP/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets_LP/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets_LP/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets_LP/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets_LP/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets_LP/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets_LP/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Vesperr - v4.5.0
  * Template URL: https://bootstrapmade.com/vesperr-free-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <div class="logo">
        <h1><a href="home.html">SeaFood</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link" href="home.php">Home</a></li>
          <li><a class="getstarted" href="login.php">Login</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

      <!-- <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto" href="home.php">Home</a></li>
          <li><a class="getstarted scrollto" href="login.php">Login</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>.navbar -->

    </div>
  </header><!-- End Header -->

  <section class="vh-100" style="background-color: #222222;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card login shadow-2-strong" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">

              <h3 class="mb-5">Sign in</h3>
              <form action="" method="post">
              <div class="form mb-2">
                <input type="email" id="#" class="form-control form-control-sm" name="email" placeholder="Email"/>
              </div>

              <div class="form mb-4">
                <input type="password" id="#" class="form-control form-control-sm" name="password" placeholder="Password"/>
              </div>

              <button class="submit col-12 btn btn-md btn-block" name="submit" type="submit">Login</button>
              </form>
              <p class="mt-4 text-sm text-center">Don't have an account?
                <a href="registrasi.php" class="text text-gradient font-weight-bold">Sign Up</a>
              </p>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets_LP/vendor/aos/aos.js"></script>
  <script src="assets_LP/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets_LP/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets_LP/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets_LP/vendor/php-email-form/validate.js"></script>
  <script src="assets_LP/vendor/purecounter/purecounter.js"></script>
  <script src="assets_LP/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets_LP/js/main.js"></script>
</body>

</html>