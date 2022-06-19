<?php 
	// panggil koneksi ke database
	require_once '../config/database.php';
	require '../../functions.php';
	
	// errror
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


	$id_pemesanan 	= $_GET['id_pemesanan'];
	$id_pegawai 	= $_GET['id_pegawai'];
			  
	// masukkan data ke database
	$query 					= "UPDATE pemesanan SET status_pemesanan = '04' WHERE id_pemesanan = '$id_pemesanan'"; 
	$sql 					= mysqli_query($koneksi, $query);

	$id_pembayaran 			= query("SELECT id_pembayaran FROM pembayaran WHERE id_pemesanan = '$id_pemesanan'")[0]["id_pembayaran"];
	$date 					= date('Y-m-d');

	$query 					= "INSERT INTO pengiriman (id_pegawai, id_pembayaran, status_pengiriman, tanggal_pengiriman) 
							   VALUES ($id_pegawai, $id_pembayaran, 1, '$date')";
	$sql 					= mysqli_query($koneksi, $query);
	
	if ($sql) {
		header('location: ../pages/order.php');
	} else {
		echo "gagal input data";
	}
?>