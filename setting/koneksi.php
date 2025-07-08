<?php
//error_reporting(0);
//set koneksi ke basis data
$host = "localhost"; //Berjalan di local
$username = "tagy3641_nusa";
$password = "29^mcZTa}bLfDPrc";
$db_name = "tagy3641_akt"; //Nama database

//koneksi ke basis data
$mysqli = new mysqli($host, $username, $password, $db_name);

//Cek koneksi basis data
if(mysqli_connect_errno()) {
	echo "Error: Tidak terhubung ke database";
	exit;
	}
?>