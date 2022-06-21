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

    // Query Semua Barang
    $barang = query("SELECT * FROM barangToko");

    // Query Barang Yang ditawarkan terakhir.
    $tglPenawaranTerakhir = query("SELECT TGL_PENAWARAN_TERAKHIR FROM CALON_KONSUMEN 
                                   WHERE EMAIL_CALON_KONSUMEN = '$emailKonsumen'");
    // die(var_dump($tglPenawaranTerakhir));
    if($tglPenawaranTerakhir[0]["TGL_PENAWARAN_TERAKHIR"]!= null){
    $tglPenawaranTerakhir = $tglPenawaranTerakhir[0]["TGL_PENAWARAN_TERAKHIR"];
    $idPenawaran = query("SELECT id_penawaran FROM penawaran 
                          WHERE tgl_penawaran = '$tglPenawaranTerakhir'");
    // die(var_dump($idPenawaran));
    $idPenawaran = (string)$idPenawaran[0]["id_penawaran"];
    $idKatalog = query("SELECT id_katalog FROM penawaran WHERE id_penawaran = '$idPenawaran'")[0];
    $idKatalog = $idKatalog["id_katalog"];
    $idBarang = query("SELECT id_barang FROM detail_katalog WHERE id_katalog = '$idKatalog'");
    //$idBarang = query("CALL getBarangPenawaran('$emailKonsumen')");
    $a = 0;
    foreach ($idBarang as $idBarang){
      $array[$a] = $idBarang["id_barang"];
      $a++;
    }
    $array = "'" .implode("','", $array  ) . "'";
    $array = (string)$array;
    $barangPenawaran = query("SELECT * FROM barang WHERE id_barang IN ($array)");
    }
    if (isset($_POST["submit"])){
        $id = $_REQUEST["idBarang"];
        $sisaBarang = query("SELECT stok_barang FROM barang WHERE id_barang = '$id'")[0];
        $sisaBarang = $sisaBarang["stok_barang"];
        
        if($sisaBarang > 0){
            header("Location: pemesanan.php");
        }
        else {
            echo "
                <script>
                    alert('Barang Habis');
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
        <h1><a href="home.html">SeaFood</a></h1>
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
    <?php
    if($tglPenawaranTerakhir[0]["TGL_PENAWARAN_TERAKHIR"] != null){
    ?>
    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Spesial untuk Anda</h2>
          <p>Penawaran terbaru yang anda terima</p>
        </div>
        
        <div class="row">
          <?php foreach ($barangPenawaran as $item){?>
            <div class="col-md-6 col-lg-3 align-items-stretch mb-5 mb-lg-0 pb-3">
              <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
                <h4 class="title"><a href=""><?= $item["NAMA_BARANG"]; ?></a></h4>
                <p class="description">Rp.<?= $item["HARGA_JUAL"]; ?></p>
                <br>
                <a href="pemesanan.php?idBarang=<?= $item["ID_BARANG"]; ?>" class="btn btn-dark btn-sm tombol">
                  Pesan Sekarang
                </a>
              </div>
            </div>
          <?php } ?>
        </div>
        

      </div>
    </section><!-- End Services Section -->
    <?php
    } 
    ?>
    <hr>
    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
      <div class="container">

      <div class="section-title" data-aos="fade-up">
          <h2>Barang</h2>
          <p>Barang lainnya yang masih tersedia</p>
        </div>

      <div class="row">
        <?php foreach ($barang as $item){?>
          <div class="col-md-6 col-lg-3 align-items-stretch mb-5 mb-lg-0 pb-3">
            <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
              <h4 class="title"><a href=""><?= $item["nama_barang"]; ?></a></h4>
              <p class="description">Rp.<?= $item["harga_jual"]; ?></p>
              <br>
              <a href="pemesanan.php?idBarang=<?= $item["id_barang"]; ?>" class="btn btn-dark btn-sm tombol">
                Pesan Sekarang
              </a>
            </div>
          </div>
        <?php } ?>
      </div>

      </div>
    </section><!-- End Services Section -->


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