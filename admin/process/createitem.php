<?php 
	// panggil koneksi ke database
	require_once '../config/database.php';
	require '../../functions.php';
	
	// errror
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


	if (isset($_POST['add'])) { 
		$id_barang		= query("SELECT id_barang FROM barang ORDER BY id_barang DESC LIMIT 1")[0]["id_barang"];
		$id_barang		= (int)$id_barang+1;
		$id_jenis     	= $_POST['id_jenis'];
		$nama_barang   	= $_POST['nama_barang'];
        $stok_barang   	= $_POST['stok_barang'];
        $berat_barang  	= $_POST['berat_barang'];
        $harga_jual 	= $_POST['harga_jual'];

		// masukkan data ke database
		$query  = "INSERT INTO barang VALUES ('$id_barang','$id_jenis','$nama_barang','$stok_barang','$berat_barang'
                                                ,'$harga_jual',NULL)"; 
		$sql 	= mysqli_query($koneksi, $query);
		
		if ($sql) {
			header('location: ../pages/item.php');
		} else {
			echo "gagal input data";
		}
	}
?>