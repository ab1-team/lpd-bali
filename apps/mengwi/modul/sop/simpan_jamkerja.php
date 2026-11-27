<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="kecamatan";
$id_kec=$_SESSION['lokasi'];

$kd_kec			=$_POST['kd_kec'];
$jam_masuk		=$_POST['jam_masuk'];
$jam_pulang		=$_POST['jam_pulang'];

	$input	= "UPDATE $table SET 	jam_masuk='$jam_masuk',
									jam_pulang='$jam_pulang'
					WHERE id= '$id_kec'";
	mysql_query($input);								
	
?>