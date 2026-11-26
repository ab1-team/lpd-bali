<?php

$server1 =  getenv("LPD_DB_HOST") ?: "db";
$username1 = "siupkonl_payment";
$password1 = "tanyamasrafiaja";

$server2 =  getenv("LPD_DB_HOST") ?: "db";
$username2 = "siupkonl_new";
$password2 = "upkbaru";


// Koneksi dan memilih database di server
//mysql_connect($server,$username,$password) or die("");
//mysql_select_db($database) or die("");

// mengatur koneksi dan disimpan dalam satu variabel
error_reporting(E_ALL ^ E_DEPRECATED);
$koneksi_1 = mysql_connect($server1, $username1, $password1) or die ("Gagal konek ke server MySQL" .mysql_error());
$koneksi_2 = mysql_connect($server2, $username2, $password2, true) or die ("Gagal konek ke server MySQL" .mysql_error());
 
// mengatur pemilihan database sesuai koneksi
mysql_select_db('siupkonl_payment', $koneksi_1 ) or die ("Gagal membuka database1" .mysql_error());
mysql_select_db('siupkonl_new', $koneksi_2 ) or die ("Gagal membuka database2" .mysql_error());

?>