<?php session_start(); 
include "../../inc/inc.koneksi.php";
$table		="rekening_$_SESSION[lokasi]";
$tahun		=$_POST['tahun'];
$kolom		="tb$tahun";
$_SESSION['tahunbuku']	=$_POST['tahun'];

	$input = "ALTER TABLE $table ADD $kolom VARCHAR(255) NOT NULL DEFAULT '0' AFTER tgl_awal";
	mysql_query($input);

?>