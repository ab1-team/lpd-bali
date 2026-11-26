<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="anggota_$_SESSION[kd_kab]";

$nik			=$_POST['nik'] ?: 0;
$kecamatan		=$_POST['kecamatan'] ?: 0;
$desamut		=$_POST['desamut'] ?: 0;

	$input	= "UPDATE $table SET 	desa='$desamut', lokasi='$kecamatan'
					WHERE nik= '$nik' ";
	mysql_query($input);								
	
?>