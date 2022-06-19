<?php 
	// panggil koneksi ke database
	require_once '../config/database.php';
	require '../../functions.php';
	
	// errror
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


	if (isset($_POST['add-offer'])) { 
		$id_penawaran     		= $_POST['id_penawaran'];
    	$pelanggan     			= $_POST['pelanggan'];
		$i = 0;
		if ($pelanggan == 1){
			$penawaran		= query("SELECT id_calon_konsumen, COUNT(id_pemesanan) FROM pemesanan
										 WHERE status_pemesanan LIKE '03'
										 GROUP BY id_calon_konsumen");
			foreach($penawaran as $penawaran){
				$idDiTawari[$i] = $penawaran["id_calon_konsumen"];
				$i++;
			}
		} else if($pelanggan == 2){
			$penawaran		= query("SELECT id_calon_konsumen, COUNT(id_pemesanan) FROM pemesanan
										 WHERE status_pemesanan LIKE '03'
										 GROUP BY id_calon_konsumen LIMIT 10");
			foreach($penawaran as $penawaran){
				$idDiTawari[$i] = $penawaran["id_calon_konsumen"];
				$i++;
			}
		} else if($pelanggan == 3){
			$penawaran		= query("SELECT id_calon_konsumen, COUNT(id_pemesanan) FROM pemesanan
										 WHERE status_pemesanan LIKE '03'
										 GROUP BY id_calon_konsumen LIMIT 50");
			foreach($penawaran as $penawaran){
				$idDiTawari[$i] = $penawaran["id_calon_konsumen"];
				$i++;
			}
		}
	
		// masukkan data ke database
		foreach ($idDiTawari as $idDiTawari){
			$idDetailPenawaran		= query("SELECT id_detail_penawaran FROM detail_penawaran ORDER BY id_detail_penawaran DESC LIMIT 1")[0]["id_detail_penawaran"];
			$idDetailPenawaran++;
			$query 					= "INSERT INTO detail_penawaran VALUES ($idDetailPenawaran, '$id_penawaran','$idDiTawari',NULL ,NULL)"; 
			$sql 					= mysqli_query($koneksi, $query);
		}
		
		if ($sql) {
			header('location: ../pages/offer.php');
		} else {
			echo "gagal input data";
		}
	}
?>