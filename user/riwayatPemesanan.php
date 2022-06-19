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

    // Pemesanan belum dibayar
    $pesanBelumBayar = query("SELECT b.nama_barang, p.id_pemesanan, p.tgl_pemesanan, p.status_pemesanan, 
                                     p.alamat_pengiriman, dp.sub_total, dp.total_berat 
                              FROM detail_pemesanan dp, barang b, pemesanan p
                              WHERE dp.id_barang = b.id_barang AND dp.id_pemesanan = p.id_pemesanan 
                                    AND p.status_pemesanan = '00' AND p.id_calon_konsumen = '$idKonsumen'");

    // Pemesanan yang sudah dibayar
    $pesanSudahBayar = query("SELECT b.nama_barang, p.id_pemesanan, p.tgl_pemesanan, p.status_pemesanan, 
                              p.alamat_pengiriman, dp.sub_total, dp.total_berat 
                              FROM detail_pemesanan dp, barang b, pemesanan p
                              WHERE dp.id_barang = b.id_barang AND dp.id_pemesanan = p.id_pemesanan 
                                    AND p.status_pemesanan = '01' AND p.id_calon_konsumen = '$idKonsumen'");

    //die(var_dump($detailPemesanan));
    if (isset($_POST["submit"])){
      if (hapus($_POST)>0){
          header("Location: riwayatPemesanan.php");
      }
      else {
          echo "
              <script>
                  alert('Login gagal');
                  document.location.href = 'riwayatPemesanan.php'
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

    <!-- ======= Pricing Section ======= -->
    <section id="pricing" class="pricing">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Pesanan Belum Dibayar</h2>
        </div>

        <div class="row">
            <?php foreach($pesanBelumBayar as $detailPemesanan){ ?>
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="box" data-aos="zoom-in-right" data-aos-delay="200">
                <h2><?= $detailPemesanan["nama_barang"]; ?></h2>
                <h4><?= $detailPemesanan["total_berat"]; ?><span> Kg</span></h4>
                <ul>
                    <h5>Rp. <?= $detailPemesanan["sub_total"]; ?></h5>
                    <li class="pt-5">Tanggal : <?= $detailPemesanan["tgl_pemesanan"]; ?></li>
                    <li>Alamat Pengiriman: <?=  $detailPemesanan["alamat_pengiriman"]; ?></li>
                    <?php if($detailPemesanan["status_pemesanan"] === '01'){ ?>
                    <li>Status Pemesanan : <a href="#" class="btn btn-warning btn-sm">Menunggu Pembayaran</a></li>
                    <?php } else if($detailPemesanan["status_pemesanan"] === '02'){ ?>
                    <li>Status Pemesanan : <a href="#" class="btn btn-warning btn-sm">Menunggu Konfirmasi Pembayaran</a></li>
                    <?php } else if($detailPemesanan["status_pemesanan"] === '03'){ ?>
                    <li>Status Pemesanan : <a href="#" class="btn btn-warning btn-sm">Pesanan Disiapkan</a></li>
                    <?php } else if($detailPemesanan["status_pemesanan"] === '04'){?>
                    <li>Status Pemesanan : <a href="#" class="btn btn-success btn-sm">Pesanan Dikirim</a></li>
                    <?php } ?>
                </ul>
                <form action="" method="post">
                  <input type="hidden" value="<?= $detailPemesanan["id_pemesanan"]; ?>" name="idPemesanan">
                  <button type="submit" name="submit" class="btn btn-danger btn-sm">
                      Batalkan Pesanan
                  </button>
                </form>
                <div class="btn-wrap">
                    <a href="pembayaran.php?idPemesanan=<?= $detailPemesanan["id_pemesanan"]; ?>" class="btn-buy">
                      Bayar Sekarang
                    </a>
                </div>
                </div>
            </div>
            <?php } ?>
        </div>

      </div>
    </section><!-- End Pricing Section -->

    <!-- ======= Pricing Section ======= -->
    <section id="pricing" class="pricing">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Pesanan Sudah Dibayar</h2>
        </div>

        <div class="row">
          <?php foreach($pesanSudahBayar as $detailPemesanan){ ?>
            <div class="col-lg-4 col-md-6 mb-3">
              <div class="box" data-aos="zoom-in-right" data-aos-delay="200">
                <h2><?= $detailPemesanan["nama_barang"]; ?></h2>
                <h4><?= $detailPemesanan["total_berat"]; ?><span> Kg</span></h4>
                <ul>
                    <h5>Rp. <?= $detailPemesanan["sub_total"]; ?></h5>
                    <li class="pt-5">Tanggal : <?= $detailPemesanan["tgl_pemesanan"]; ?></li>
                    <li>Alamat Pengiriman: <?=  $detailPemesanan["alamat_pengiriman"]; ?></li>
                    <?php if($detailPemesanan["status_pemesanan"] == 00){ ?>
                    <li>Status Pemesanan : <a href="#" class="btn btn-warning btn-sm">Menunggu Pembayaran</a></li>
                    <?php } else {?>
                    <li>Status Pemesanan : <a href="#" class="btn btn-success btn-sm">Barang Dikirim</a></li>
                    <?php } ?>
                </ul>
              </div>
            </div>
            <?php } ?>
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