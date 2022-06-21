<?php 
	// panggil koneksi ke database
	require_once '../config/database.php';
	require '../../functions.php';
	
	// errror
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


	if (isset($_POST['add-offer'])) { 
		$id_katalog     = $_POST['id_katalog'];
		$id_barang		= $_POST['id_barang'];
		// die(var_dump($id_barang));

		// masukkan data ke database
		foreach($id_barang as $id_barang){
		$query  = "INSERT INTO detail_katalog VALUES ('$id_katalog','$id_barang',NULL)"; 
		$sql 	= mysqli_query($koneksi, $query);
		}
		
		if ($sql) {
			header('location: ../pages/catalog.php');
		} else {
			echo "gagal input data";
		}
	}
?>