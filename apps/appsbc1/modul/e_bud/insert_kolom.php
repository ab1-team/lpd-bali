<?php session_start(); 
include "../../inc/inc.koneksi.php";
$table		="rekening_$_SESSION[lokasi]";
$tahun		=$_POST['tahun'];
$kolom		="ra_$tahun";
$_SESSION['tahunanggaran']	=$_POST['tahun'];

	$input = "ALTER TABLE $table ADD $kolom VARCHAR(255) NOT NULL DEFAULT '0' AFTER nama_rekening";
	mysql_query($input);

?>