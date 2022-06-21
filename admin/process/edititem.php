<?php 
	// panggil koneksi ke database
	require_once '../config/database.php';
	require '../../functions.php';
	
	// errror
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


	if (isset($_POST['add-offer'])) { 
		$id_barang		   		= $_POST['id_barang'];
		$id_jenis     			= $_POST['id_jenis'];
		$nama_barang   			= $_POST['nama_barang'];
        $stok_barang   			= $_POST['stok_barang'];
        $berat_barang  			= $_POST['berat_barang'];
        $harga_jual 			= $_POST['harga_jual'];
		// var_dump(date('Y-m-d'));
		// exit;

		// masukkan data ke database
		$query 					= "UPDATE barang SET id_jenis = '$id_jenis', 
								   					 nama_barang = '$nama_barang', 
								   					 stok_barang = $stok_barang,
								   					 berat_barang = $berat_barang,
								   					 harga_jual = $harga_jual 
								   WHERE id_barang = '$id_barang'"; 
		$sql 					= mysqli_query($koneksi, $query);
		
		if ($sql) {
			header('location: ../pages/item.php');
		} else {
			echo "
				<script>
					alert('Update Gagal');
					document.location.href = '../pages/edititem.php'
				</script>
			";
		}
	}
?>