<?php 
	// panggil koneksi ke database
	require_once '../config/database.php';
	
	// errror
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if(isset($_GET['id_pemesanan'])){
		$query 	= "DELETE FROM pemesanan WHERE id_pemesanan='".$_GET['id_pemesanan']."'";
		$sql 	= mysqli_query($db, $query);
		
		if ($sql) {
			header('location: ../pages/order.php');
		} else {
			echo "gagal hapus data";
		}
    }
?>