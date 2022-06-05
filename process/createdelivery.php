<?php 
	// panggil koneksi ke database
	require_once '../config/database.php';
	
	// errror
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


	if (isset($_POST['add-delivery'])) { 
		$id_pembayaran  = $_POST['id_pembayaran'];
		$id_pegawai     = $_POST['id_pegawai'];
			  
		// masukkan data ke database
		$query  = "INSERT INTO pengiriman VALUES (NULL,'$id_pegawai','$id_pembayaran',NULL,NULL)"; 
		$sql 	= mysqli_query($db, $query);
		
		if ($sql) {
			header('location: ../pages/delivery.php');
		} else {
			echo "gagal input data";
		}
	}
?>