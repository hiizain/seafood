<?php
    // mengaktifkan session php
    session_start();
    
    // Create database connection using config file
    require_once './config/database.php';

    // errror
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
    // menangkap data yang dikirim dari form
    $email      = $_POST['email'];
    $pass       = md5($_POST['pass']);

    // Fetch all users data from database
    $result         = "SELECT * FROM user WHERE email='$email' AND pass='$pass'";
    $signin         = mysqli_query($mysqli, $result);
    
    // menghitung jumlah data yang ditemukan
    $cek            = mysqli_num_rows($signin);
    
    if($cek > 0){
        $data   = mysqli_fetch_assoc($signin);

        if($data['role'] == "admin"){
            $_SESSION['email']   = $email;
            $_SESSION['role']    = "admin";
            header("location:../pages/dashboard/admin/dashboard.php");
        }
    } else {
        header("location:../index.php?pesan=belumDaftar");
    }
?>