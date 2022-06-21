<?php
    $koneksi = mysqli_connect('localhost','root','','seafood2');

    function query($query){
        global $koneksi;

        $select = mysqli_query($koneksi, $query);
        $rows = [];
        while ($tampil = mysqli_fetch_assoc($select)){
            $rows [] = $tampil;
        }
        return $rows;
    }

    function regis($data){
        global $koneksi;

        $idNegara = htmlspecialchars($data["negara"]);
        $nama = htmlspecialchars($data["nama"]);
        $email = htmlspecialchars($data["email"]);
        $password = mysqli_real_escape_string($koneksi, $data["password"]);

        $query = "SELECT EMAIL_CALON_KONSUMEN FROM CALON_KONSUMEN
                WHERE EMAIL_CALON_KONSUMEN = '$email'
                ";
        $result = mysqli_query($koneksi, $query);
        if(mysqli_fetch_assoc($result)){
            return false;
        }

        $password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO calon_konsumen VALUES 
                ('', '$idNegara', '$nama', '$email', '$password', NULL)
                ";

        mysqli_query($koneksi, $query);

        return mysqli_affected_rows($koneksi);
    }

    function login($data){
        global $koneksi;
        $return = null;
        $email = htmlspecialchars($data["email"]);
        $password = $data["password"];

        $queryKonsumen = "SELECT * FROM CALON_KONSUMEN
                  WHERE EMAIL_CALON_KONSUMEN = '$email'
                  ";
        $konsumen = mysqli_query($koneksi, $queryKonsumen);

        $queryAdmin = "SELECT * FROM PEGAWAI
                  WHERE EMAIL_PEGAWAI = '$email'
                  ";
        $admin = mysqli_query($koneksi, $queryAdmin);
        // var_dump(mysqli_num_rows($admin));
        // exit;
        if(mysqli_num_rows($admin) === 1){
            
            $row = mysqli_fetch_assoc($admin);
            if ($password === $row["PASS_PEGAWAI"]){
                $return = "1";
            }

        }else if(mysqli_num_rows($konsumen) === 1){
            $password = mysqli_real_escape_string($koneksi, $password);
            $row = mysqli_fetch_assoc($konsumen);
            if (password_verify($password, $row["PASSWORD_CALON_KONSUMEN"]) ){
                $return = "2";
            }

        }

        return $return;
    }
    
    function pemesanan($data){
        global $koneksi;

        $idBarang = htmlspecialchars($data["idBarang"]);
        $barang = query("SELECT * FROM barang WHERE id_barang = '$idBarang'")[0];
        $hargaBarang = (double)$barang["HARGA_JUAL"];
        $berat = (double)$barang["BERAT_BARANG"];
        $jumlah = (double)$data["jumlah"];
        $total = $jumlah*$hargaBarang;
        $totalBerat = ($jumlah*$berat);
        $emailKonsumen = htmlspecialchars($data["emailKonsumen"]);
        $idKonsumen = query("SELECT id_calon_konsumen FROM calon_konsumen WHERE email_calon_konsumen = '$emailKonsumen'")[0];
        $idKonsumen = $idKonsumen["id_calon_konsumen"];
        $alamatKirim = htmlspecialchars($data["alamat"]);
        
        $query = "INSERT INTO pemesanan (id_pegawai, id_calon_konsumen, tgl_pemesanan, status_pemesanan, alamat_pengiriman, total_harga)
                  VALUES ('1001', '$idKonsumen', DEFAULT, '01', '$alamatKirim', $total)
                  ";

        mysqli_query($koneksi, $query);
        
        $idPemesanan = query("SELECT id_pemesanan FROM pemesanan WHERE tgl_pemesanan = CURDATE() ORDER BY id_pemesanan DESC LIMIT 1;")[0];
        $idPemesanan = $idPemesanan["id_pemesanan"];

        $query = "INSERT INTO detail_pemesanan VALUES 
                  ('$idPemesanan', '$idBarang', $total, $totalBerat)
                  ";

        mysqli_query($koneksi, $query);

        $stokBarang = query("SELECT stok_barang FROM barang WHERE id_barang = '$idBarang'")[0];
        $stokBarang = $stokBarang["stok_barang"];
        $sisa = $stokBarang-$jumlah;

        $query = "UPDATE barang SET stok_barang = '$sisa' WHERE id_barang = '$idBarang'";
        mysqli_query($koneksi, $query);

        return mysqli_affected_rows($koneksi);
    }

    function pembayaran($data){
        global $koneksi;

        $idPemesanan = htmlspecialchars($data["idPemesanan"]);
        //die(var_dump($idPemesanan));
        $jenisBayar = htmlspecialchars($data["jenisBayar"]);
        //die(var_dump($jenisBayar));
        $total = (int)$data["totalBayar"];
        //die(var_dump($total));
        
        $buktiBayar = upload();
        

        if(!$buktiBayar){
            return false;
        }
        //die(var_dump($buktiBayar));

        $status = 2;
        //die(var_dump($status));

        $query = "INSERT INTO pembayaran (id_pegawai, id_pemesanan, tgl_pembayaran, bukti_pembayaran, jenis_pembayaran, status_pembayaran, total_pembayaran) 
                  VALUES ('1001', '$idPemesanan', DEFAULT, '$buktiBayar', '$jenisBayar', $status, $total)
                  ";

        mysqli_query($koneksi, $query);

        //$query = query("SELECT * FROM pembayaran");

        //die(var_dump($query));

        $query = "UPDATE pemesanan SET status_pemesanan = '02' WHERE id_pemesanan = '$idPemesanan'";
        //die(var_dump($query));
        mysqli_query($koneksi, $query);

        return mysqli_affected_rows($koneksi);
    }

    function terima($data){
        global $koneksi;

        $idPemesanan = htmlspecialchars($data["idPemesanan"]);
        //die(var_dump($idPemesanan));
        

        $query = "UPDATE pemesanan SET status_pemesanan = '05' WHERE id_pemesanan = '$idPemesanan'";
        //die(var_dump($query));
        mysqli_query($koneksi, $query);

        $idPembayaran = query("SELECT id_pembayaran FROM pembayaran WHERE id_pemesanan = '$idPemesanan'")[0]["id_pembayaran"];
        //die(var_dump($idPembayaran));
        $query = "UPDATE pengiriman SET status_pengiriman = 2 WHERE id_pembayaran = '$idPembayaran'";
        //die(var_dump($query));
        mysqli_query($koneksi, $query);

        return mysqli_affected_rows($koneksi);
    }

    function upload(){
        $namaFile = $_FILES['buktiBayar']['name'];
        $ukuranFile = $_FILES['buktiBayar']['size'];
        $error = $_FILES['buktiBayar']['error'];
        $tmpName = $_FILES['buktiBayar']['tmp_name'];

        if ($error === 4){
            echo "<script>alert('Upload file bukti bayar terlebih dahulu')</script>";
            return false;
        }

        $namaEkstensiValid = ['jpg', 'jpeg','png'];
        $ekstensi = explode('.', $namaFile);
        $ekstensi = strtolower(end($ekstensi));
        if(!in_array($ekstensi, $namaEkstensiValid)){
            echo "<script>alert('Yang anda upload bukan gambar')</script>";
            return false;
        }

        if ($ukuranFile > 1000000){
            echo "<script>alert('Ukuran gambar terlalu besar')</script>";
            return false;
        }

        $namaFileBaru = uniqid();
        $namaFileBaru .= '.';
        $namaFileBaru .= $ekstensi;

        // var_dump($namaFileBaru, $tmpName);
        // exit;

        move_uploaded_file($tmpName, '../admin/assets/bukti-pembayaran/' . $namaFileBaru);

        return $namaFileBaru;

    }

    function hapus($data){
        global $koneksi;

        $idPemesanan = htmlspecialchars($data["idPemesanan"]);
        $detailPemesanan = query("SELECT * FROM detail_pemesanan WHERE id_pemesanan = $idPemesanan")[0];
        //die(var_dump($detailPemesanan));
        $idBarang = $detailPemesanan["ID_BARANG"];
        //die(var_dump($idBarang));
        $barang = query("SELECT * FROM barang WHERE id_barang = $idBarang")[0];
        $jumlah = (int)($detailPemesanan["SUB_TOTAL"]/$barang["HARGA_JUAL"]);
        $stok = $jumlah+$barang["STOK_BARANG"];

        //die(var_dump($idPemesanan));
        $query = "DELETE FROM detail_pemesanan WHERE id_pemesanan = '$idPemesanan'";
        mysqli_query($koneksi, $query);

        $query = "DELETE FROM pemesanan WHERE id_pemesanan = '$idPemesanan'";
        mysqli_query($koneksi, $query);

        $query = "UPDATE barang SET stok_barang = $stok WHERE id_barang = $idBarang";
        mysqli_query($koneksi, $query);

        return mysqli_affected_rows($koneksi);
    }

    function hapusSemua(){
        global $koneksi;
        mysqli_query($koneksi, "TRUNCATE TABLE tamu");

        return mysqli_affected_rows($koneksi);
    }

    function ubah($data){
        global $koneksi;

        $id = $data["id"];
        $nama = htmlspecialchars($data["nama"]);
        $noKursi = htmlspecialchars($data["noKursi"]);
        $fotoLama = htmlspecialchars($data["fotoLama"]);
        $noHP = htmlspecialchars($data["noHP"]);
        $email = htmlspecialchars($data["email"]);

        if ($_FILES['foto']['error'] === 4){
            $foto = $fotoLama;
        } else {
            $foto = upload();
        }

        $query = "UPDATE tamu SET
                  nama_tamu = '$nama', 
                  no_kursi = '$noKursi',
                  foto = '$foto',
                  no_hp = '$noHP',
                  email = '$email' 
                  WHERE id_tamu = $id
                  ";

        mysqli_query($koneksi, $query);

        return mysqli_affected_rows($koneksi);
    }

    function view($keyword){
        $query = "SELECT * FROM tamu WHERE no_hp = $keyword";
        return query($query);
    }

    function cekKode($noHP){

        $query = "SELECT * FROM tamu";
        $data = query($query);
        $sama = 0;
        foreach($data as $data){
            if ($data["no_hp"] != $noHP){
                $sama = $sama+0;
            }
            else{
                $sama = $sama+1;
            }
        }

        if ($sama === 1){
            return true;
        } else{
            return false;
        }

        //return mysqli_affected_rows($koneksi);

    }

    function presensi($data){
        global $koneksi;

        $id = $data["id"];
        $kehadiran = 1;

        $query = "UPDATE tamu SET
                  kehadiran = $kehadiran, 
                  jam = CURTIME(),
                  tanggal = CURDATE() 
                  WHERE id_tamu = $id
                  ";

        mysqli_query($koneksi, $query);

        return mysqli_affected_rows($koneksi);
    }

    function cekKehadiran($noHP){

        $query = "SELECT * FROM tamu WHERE no_hp = $noHP";
        $data = query($query)[0];

        if ($data["kehadiran"] != 1){
            return true;
        } else{
            return false;
        }

        //return mysqli_affected_rows($koneksi);

    }
?>