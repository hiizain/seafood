<?php 
	// panggil koneksi ke database
	require_once '../config/database.php';
	require '../../functions.php';
	
	// errror
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if(isset($_GET['id_pegawai'])){
		$query 	= "DELETE FROM pegawai WHERE id_pegawai='".$_GET['id_pegawai']."'";
		$sql 	= mysqli_query($koneksi, $query);
		
		if ($sql) {
			header('location: ../pages/employee.php');
		} else {
			echo "gagal hapus data";
		}
    }
?>