<?php 
	// panggil koneksi ke database
	require_once '../config/database.php';
	
	// errror
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


	if (isset($_POST['add-payment'])) { 
		$id_pegawai     	= $_POST['id_pegawai'];
		$id_pemesanan       = $_POST['id_pemesanan'];

		$bukti_pembayaran	= $_FILES['bukti_pembayaran']['name'];
		$lokasi				= $_FILES['bukti_pembayaran']['tmp_name'];
		move_uploaded_file($lokasi, '../assets/bukti-pembayaran/'.$bukti_pembayaran);

		$jenis_pembayaran	= $_POST['jenis_pembayaran'];
		$total_pembayaran	= $_POST['total_pembayaran'];
			  
		// masukkan data ke database
		$query 					= "INSERT INTO pembayaran (ID_PEGAWAI, ID_PEMESANAN, BUKTI_PEMBAYARAN, JENIS_PEMBAYARAN, TOTAL_PEMBAYARAN)
									VALUES ('$id_pegawai','$id_pemesanan','$bukti_pembayaran','$jenis_pembayaran','$total_pembayaran')"; 
		$sql 					= mysqli_query($db, $query);
		
		if ($sql) {
			header('location: ../pages/payment.php');
		} else {
			echo "gagal input data";
		}
	}
?>