<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="kecamatan";
$id_kec=$_SESSION['lokasi'];

$kd_kec			=$_POST['kd_kec'] ?: '0';
$jam_masuk		=$_POST['jam_masuk'] ?: '0';
$jam_pulang		=$_POST['jam_pulang'] ?: '0';

	$input	= "UPDATE $table SET 	jam_masuk='$jam_masuk',
									jam_pulang='$jam_pulang'
					WHERE id= '$id_kec'";
	mysql_query($input);								
	
?>