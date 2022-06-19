<?php 
	// panggil koneksi ke database
	require_once '../config/database.php';
	
	// errror
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if(isset($_GET['id_pembayaran'])){
		$query 	= "DELETE FROM pembayaran WHERE id_pembayaran='".$_GET['id_pembayaran']."'";
		$sql 	= mysqli_query($db, $query);
		
		if ($sql) {
			header('location: ../pages/payment.php');
		} else {
			echo "gagal hapus data";
		}
    }
?>