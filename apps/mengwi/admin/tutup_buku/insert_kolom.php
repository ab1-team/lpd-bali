<?php session_start(); 
include "../../inc/inc.koneksi.php";
$table		="admin_rekening";
$tahun		=$_POST['tahun'];
$kolom		="tb$tahun";
$_SESSION['tahunbuku']	=$_POST['tahun'];

	$input = "ALTER TABLE $table ADD $kolom VARCHAR(255) NOT NULL DEFAULT '0' AFTER posisi";
	mysql_query($input);

?>