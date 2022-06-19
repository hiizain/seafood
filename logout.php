<?php
session_start();

if ( isset($_SESSION["login"]) ){
  header("Location: toko.php");
}

session_destroy();
header("Location: home.php")

?>