<?php 
	// panggil koneksi ke database
	require_once '../config/database.php';
	
	// errror
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


	if (isset($_POST['add-order'])) { 
		$id_pegawai     	= $_POST['id_pegawai'];
		$id_calon_konsumen  = $_POST['id_calon_konsumen'];
  		$id_penawaran       = $_POST['id_penawaran'];
  		$alamat_pengiriman  = $_POST['alamat_pengiriman'];
  		$total_harga        = $_POST['total_harga'];
			  
		// masukkan data ke database
		$query 					= "INSERT INTO pemesanan (ID_PEGAWAI, ID_CALON_KONSUMEN, ID_PENAWARAN, ALAMAT_PENGIRIMAN, TOTAL_HARGA)
									 VALUES ('$id_pegawai','$id_calon_konsumen','$id_penawaran','$alamat_pengiriman','$total_harga')"; 
		$sql 					= mysqli_query($db, $query);
		
		if ($sql) {
			header('location: ../pages/order.php');
		} else {
			echo "gagal input data";
		}
	}
?>