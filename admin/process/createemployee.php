<?php 
	// panggil koneksi ke database
	require_once '../config/database.php';
	require '../../functions.php';
	
	// errror
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


	if (isset($_POST['add'])) { 
		$id_pegawai		= query("SELECT id_pegawai FROM pegawai ORDER BY id_pegawai DESC LIMIT 1")[0]["id_pegawai"];
		$id_pegawai		= (int)$id_pegawai+1;
		$id_jabatan     = $_POST['id_jabatan'];
		$nama_pegawai   = $_POST['nama_pegawai'];
        $telp_pegawai   = $_POST['telp_pegawai'];
        $email_pegawai  = $_POST['email_pegawai'];
        $alamat_pegawai = $_POST['alamat_pegawai'];
        $jk_pegawai     = $_POST['jk_pegawai'];
        $pass_pegawai   = $_POST['pass_pegawai'];

		// masukkan data ke database
		$query  = "INSERT INTO pegawai VALUES ('$id_pegawai','$id_jabatan','$nama_pegawai','$telp_pegawai','$email_pegawai'
                                                ,'$alamat_pegawai','$jk_pegawai','$pass_pegawai')"; 
		$sql 	= mysqli_query($koneksi, $query);
		
		if ($sql) {
			header('location: ../pages/employee.php');
		} else {
			echo "gagal input data";
		}
	}
?>