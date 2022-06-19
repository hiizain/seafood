<?php
    session_start();
    if ( !isset($_SESSION["login"]) ){
    header("Location: login.php");
    }
    require '../functions.php';
    $emailKonsumen = $_SESSION["email"];
    // ambil nama konsumen dengan fungsi
    $konsumen = query("SELECT * FROM calon_konsumen WHERE email_calon_konsumen = '$emailKonsumen'")[0];
    // <<$namaKonsumen = query("SELECT nama($emailKonsumen) AS nama_calon_konsumen");>>
    $namaKonsumen = $konsumen["NAMA_CALON_KONSUMEN"];
    $idKonsumen = $konsumen["ID_CALON_KONSUMEN"];
    
    $id = $_GET["idBarang"];
    $sisaBarang = query("SELECT stok_barang FROM barang WHERE id_barang = '$id'")[0];
    $sisaBarang = $sisaBarang["stok_barang"];
    
    if($sisaBarang > 0) {
        // Mengambil data barang
        $idBarang = $id;
        $barang = query("SELECT * FROM barang WHERE id_barang = '$idBarang'")[0];
    }
    else {
        echo "
            <script>
                alert('Barang Habis');
                document.location.href = 'toko.php'
            </script>
        ";
    }

    if (isset($_POST["submit"])){
        if (pemesanan($_POST)>0){
            echo "
                <script>
                    alert('Pemesanan berhasil dilakukan');
                    document.location.href = 'riwayatPemesanan.php'
                </script>
            ";
        }
        else {
            echo "
                <script>
                    alert('Barang gagal dipesan');
                    document.location.href = 'toko.php'
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
  <link href="../assets_LP/img/favicon.png" rel="icon">
  <link href="../assets_LP/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets_LP/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets_LP/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets_LP/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets_LP/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets_LP/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets_LP/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets_LP/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets_LP/css/style.css" rel="stylesheet">

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
        <h1><a href="toko.php">SeaFood</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link" href="toko.php">Toko</a></li>
          <li><a href="riwayatPemesanan.php">Riwayat Pesanan</a></li>
          <li><a href="riwayatPembayaran.php">Riwayat Pembayaran</a></li>
          <li class="dropdown"><a href="#"><span>Halo, <?= $namaKonsumen; ?>!</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="../logout.php">Logout</a></li>
            </ul>
          </li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <main id="main">
    <section id="pricing" class="pricing">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Pemesanan</h2>
        </div>

        <div class="row justify-content-md-center">
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="box" data-aos="fade-up" data-aos-delay="200">
                <h2><?= $barang["NAMA_BARANG"]; ?></h2>
                <h4><?= $barang["BERAT_BARANG"]; ?><span> Kg</span></h4>
                <form action="" method="post">

                <input type="hidden" class="form-control mt-4 form-control-user"
                    id="idBarang" placeholder="id" name="idBarang" value="<?= $idBarang; ?>">
                <input type="hidden" class="form-control mt-4 form-control-user"
                    id="emailKonsumen" placeholder="emailKonsumen" name="emailKonsumen" 
                        value="<?= $emailKonsumen; ?>">
                <input type="number" min="0" class="form-control mt-4 form-control-user"
                    id="jumlah" placeholder="Jumlah" name="jumlah" required>
                <textarea class="form-control mt-4" name="alamat" placeholder="Masukkan alamat pengiriman" 
                    id="exampleFormControlTextarea1" rows="3"></textarea>

                <button class="submit col-12 mt-4 btn btn-md btn-block" name="submit" type="submit">Pesan</button>
                </form>
                </div>
            </div>

        </div>

      </div>
    </section><!-- End Pricing Section -->


  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../assets_LP/vendor/aos/aos.js"></script>
  <script src="../assets_LP/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets_LP/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets_LP/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../assets_LP/vendor/php-email-form/validate.js"></script>
  <script src="../assets_LP/vendor/purecounter/purecounter.js"></script>
  <script src="../assets_LP/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets_LP/js/main.js"></script>

</body>

</html>