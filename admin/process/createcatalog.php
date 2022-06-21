<?php 
	// panggil koneksi ke database
	require_once '../config/database.php';
	require '../../functions.php';
	
	// errror
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


	if (isset($_POST['add-offer'])) { 
		$id_katalog				= query("SELECT id_katalog FROM katalog ORDER BY id_katalog DESC LIMIT 1")[0]["id_katalog"];
		$id_katalog				= (int)$id_katalog+1;
    	$nama_katalog     		= $_POST['nama_katalog'];
		// var_dump(date('Y-m-d'));
		// exit;
	
		// masukkan data ke database
		$query 					= "INSERT INTO katalog VALUES ('$id_katalog','$nama_katalog',NULL)"; 
		$sql 					= mysqli_query($koneksi, $query);
		
		if ($sql) {
			header('location: ../pages/catalog.php');
		} else {
			echo "gagal input data";
		}
	}
?>