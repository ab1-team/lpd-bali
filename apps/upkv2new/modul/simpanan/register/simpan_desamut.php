<?php session_start();
include "../../../inc/inc.koneksi.php";
$table		="anggota_$_SESSION[kd_kab]";

$nik			=$_POST['nik'];
$kecamatan		=$_POST['kecamatan'];
$desamut		=$_POST['desamut'];

	$input	= "UPDATE $table SET 	desa='$desamut', lokasi='$kecamatan'
					WHERE nik= '$nik' ";
	mysql_query($input);								
	
?>