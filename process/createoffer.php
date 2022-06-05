<?php 
	// panggil koneksi ke database
	require_once '../config/database.php';
	
	// errror
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


	if (isset($_POST['add-offer'])) { 
		$id_katalog     		= $_POST['id_katalog'];
    	$id_pegawai     		= $_POST['id_pegawai'];
	
		// masukkan data ke database
		$query 					= "INSERT INTO penawaran VALUES (NULL,'$id_katalog','$id_pegawai',NULL)"; 
		$sql 					= mysqli_query($db, $query);
		
		if ($sql) {
			header('location: ../pages/offer.php');
		} else {
			echo "gagal input data";
		}
	}
?>