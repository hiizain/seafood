<?php 
	// panggil koneksi ke database
	require_once '../config/database.php';
	require '../../functions.php';
	
	// errror
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


	if (isset($_POST['add-offer'])) { 
		$id_katalog     		= $_POST['id_katalog'];
    	$id_pegawai     		= $_POST['id_pegawai'];
		$id_penawaran			= query("SELECT id_penawaran FROM penawaran ORDER BY id_penawaran DESC LIMIT 1")[0]["id_penawaran"];
		$id_penawaran			= (int)$id_penawaran+1;
		// var_dump(date('Y-m-d'));
		// exit;
	
		// masukkan data ke database
		$query 					= "INSERT INTO penawaran VALUES ('$id_penawaran','$id_katalog','$id_pegawai',DEFAULT)"; 
		$sql 					= mysqli_query($koneksi, $query);
		
		if ($sql) {
			header('location: ../pages/offer.php');
		} else {
			echo "gagal input data";
		}
	}
?>