<?php 
	// panggil koneksi ke database
	require_once '../config/database.php';
	
	// errror
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if(isset($_GET['id_penawaran'])){
		$query 	= "DELETE FROM penawaran WHERE id_penawaran='".$_GET['id_penawaran']."'";
		$sql 	= mysqli_query($db, $query);
		
		if ($sql) {
			header('location: ../pages/offer.php');
		} else {
			echo "gagal hapus data";
		}
    }
?>