<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="desa";
$id=$_SESSION['lokasi'];

$def_jasa			=$_POST['def_jasa'];
$def_jangka		=$_POST['def_jangka'];
$pembulatan		=$_POST['pembulatan'];
$tgl_toleransi		=$_POST['tgl_toleransi'];

	$input	= "UPDATE $table SET 	def_jasa='$def_jasa',
									def_jangka='$def_jangka',
									pembulatan='$pembulatan',
									tgl_toleransi='$tgl_toleransi'
					WHERE id= '$id'";
	mysql_query($input);								
	
?>