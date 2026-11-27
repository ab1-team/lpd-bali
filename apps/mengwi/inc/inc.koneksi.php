<?php

$server = getenv("LPD_DB_HOST") ?: "db"; 
$username = getenv("LPD_DB_USER") ?: "lpdbalii_siupkonline2";  
$password = getenv("LPD_DB_PASS") ?: "lpdbalii_siupkonline2"; //upkbaru
$database = "lpdbalii_siupkonline_baru";
 
$konek = mysql_connect($server, $username, $password) or die ("Gagal konek ke server MySQL" .mysql_error());
$bukadb = mysql_select_db($database) or die ("Gagal membuka database " .mysql_error());

date_default_timezone_set('Asia/Jakarta');
?>