<?php 
	// panggil koneksi ke database
	require_once '../config/database.php';
	require '../../functions.php';
	
	// errror
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


	$id_pembayaran   	= $_GET['id_pembayaran'];
			  
	// masukkan data ke database
	$query 					= "UPDATE pembayaran SET status_pembayaran = 3 WHERE id_pembayaran = '$id_pembayaran'"; 
	$sql 					= mysqli_query($koneksi, $query);

	if ($sql) {
		$id_pemesanan 			= query("SELECT id_pemesanan FROM pembayaran WHERE id_pembayaran = '$id_pembayaran'")[0]["id_pemesanan"];
		// var_dump($id_pemesanan);
		// exit;
		$query 					= "UPDATE pemesanan SET status_pemesanan = '03' WHERE id_pemesanan = '$id_pemesanan'"; 
		$sql 					= mysqli_query($koneksi, $query);
		if ($sql) {
			header('location: ../pages/payment.php');
		} else {
			echo "gagal input data";
		}
	} else {
		echo "gagal input data";
	}

	
?>