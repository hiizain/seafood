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

    // Pengambilan data barang 
    $idPemesanan = $_GET["idPemesanan"];
    $pemesanan = query("SELECT * FROM pemesanan where id_pemesanan = '$idPemesanan'")[0];
    $detailPemesanan = query("SELECT * FROM detail_pemesanan WHERE id_pemesanan = '$idPemesanan'")[0];
    $idBarang = $detailPemesanan["ID_BARANG"];
    $barang = query("SELECT * FROM barang WHERE id_barang = '$idBarang'")[0];


    if (isset($_POST["submit"])){
        if (pembayaran($_POST)>0){
            echo "
                <script>
                    alert('Pembayaran berhasil dilakukan');
                    document.location.href = 'riwayatPembayaran.php'
                </script>
            ";
        }
        else {
            echo "
                <script>
                    alert('Pembayaran gagal');
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
    <section class="pembayaran">
      <div class="container">
        
        <div class="section-title" data-aos="fade-up">
          <h2>Pembayaran</h2>
        </div>

        <div class="row d-flex justify-content-center align-items-center" data-aos="zoom-in" data-aos-delay="100">
          <div class="col-12 col-md-12 col-lg-10">
            <div class="card shadow-2-strong" style="border-radius: 1rem;">
              <div class="card-body p-5 text-center">

                <form action="" method="post" enctype="multipart/form-data">
                <div class="row mb-2">
                    <div class="col-md-4 d-flex text-left">Nama Barang</div>
                    <div class="col-md-1">:</div>
                    <div class="col-md-7 d-flex text-left"><?= $barang["NAMA_BARANG"]; ?></div>
                </div>  
                <div class="row mb-2">
                    <div class="col-md-4 d-flex text-left">Alamat Pengiriman</div>
                    <div class="col-md-1">:</div>
                    <div class="col-md-7 d-flex text-left"><?= $pemesanan["ALAMAT_PENGIRIMAN"]; ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 d-flex text-left">Bukti Bayar</div>
                    <div class="col-md-1">:</div>
                    <div class="form-group col-md-7 d-flex text-left">
                          <input type="file" class="form-control form-control-user text-center"
                              name="buktiBayar" required>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 d-flex text-left">Metode Pembayaran</div>
                    <div class="col-md-1">:</div>
                    <div class="form-group col-md-7 d-flex text-left">
                          <select name="jenisBayar" class="form-control text-center">
                              <option value=""> - Pilih Metode Pembayaran -</option>
                              <option value="COD">COD</option>
                              <option value="Transfer">Transfer</option>
                          </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 d-flex text-left">Berat Total</div>
                    <div class="col-md-1">:</div>
                    <div class="col-md-7 d-flex text-left"><?= $detailPemesanan["TOTAL_BERAT"]; ?> kg</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 d-flex text-left">Total Harga</div>
                    <div class="col-md-1">:</div>
                          <input type="hidden" readonly class="form-control form-control-user text-center"
                              id="total" value="<?= $pemesanan["TOTAL_HARGA"]; ?>" 
                              placeholder="<?= $pemesanan["TOTAL_HARGA"]; ?>" name="totalBayar">
                    <div class="col-md-7 d-flex text-left">Rp. <?= $pemesanan["TOTAL_HARGA"]; ?></div>
                </div> 
                <input type="hidden" readonly class="form-control form-control-user text-center"
                      id="idPemesanan" value="<?= $idPemesanan; ?>" name="idPemesanan">
                <button type="submit" name="submit" class="btn-buy mt-5 col-md-3">Bayar</button>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>


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