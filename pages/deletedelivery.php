<?php 
	// panggil koneksi ke database
	require_once '../config/database.php';
	
	// errror
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if(isset($_GET['no_resi'])){
		$query 	= "DELETE FROM pengiriman WHERE no_resi='".$_GET['no_resi']."'";
		$sql 	= mysqli_query($db, $query);
		
		if ($sql) {
			header('location: ../pages/delivery.php');
		} else {
			echo "gagal hapus data";
		}
    }
?>