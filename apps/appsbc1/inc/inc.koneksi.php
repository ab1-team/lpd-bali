<?php
$server = getenv("LPD_DB_HOST") ?: "db"; 

$database = getenv("LPD_DB_NAME") ?: "lpdbalii_demo";
$username = getenv("LPD_DB_USER") ?: "lpdapp";
$password = getenv("LPD_DB_PASS") ?: "lpdapp2026";
$konek = mysql_connect($server, $username, $password) or die ("Gagal konek ke server MySQL" .mysql_error());
$bukadb = mysql_select_db($database) or die ("Gagal membuka database $database" .mysql_error());

date_default_timezone_set('Asia/Jakarta');



?>