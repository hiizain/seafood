<?php 
	// panggil koneksi ke database
	require_once '../config/database.php';
	require '../../functions.php';
	
	// errror
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


	if (isset($_POST['add-offer'])) { 
		$id_barang		   		= $_POST['id_barang'];
    	$stokTambah		     	= $_POST['stok'];
		// var_dump(date('Y-m-d'));
		// exit;
		
		$stok 					= query("SELECT stok_barang FROM barang WHERE id_barang = '$id_barang'")[0]["stok_barang"];
		$stok 					= $stok+$stokTambah;
		// masukkan data ke database
		$query 					= "UPDATE barang SET stok_barang = $stok WHERE id_barang = '$id_barang'"; 
		$sql 					= mysqli_query($koneksi, $query);
		
		if ($sql) {
			header('location: ../pages/item.php');
		} else {
			echo "gagal input data";
		}
	}
?>