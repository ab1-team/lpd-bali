<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="kecamatan";
$id_kec=$_SESSION['lokasi'];

$sebutan_level_1			=$_POST['sebutan_level_1'];
$sebutan_level_2		=$_POST['sebutan_level_2'];
$sebutan_level_3		=$_POST['sebutan_level_3'];

	$input	= "UPDATE $table SET 	sebutan_level_1='$sebutan_level_1',
									sebutan_level_2='$sebutan_level_2',
									sebutan_level_3='$sebutan_level_3'
					WHERE id= '$id_kec'";
	mysql_query($input);								
	
?>