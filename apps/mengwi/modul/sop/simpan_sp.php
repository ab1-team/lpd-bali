<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="kecamatan";
$id_kec=$_SESSION['lokasi'];

$def_jasa			=$_POST['def_jasa'];
$def_jangka		=$_POST['def_jangka'];
$pembulatan		=$_POST['pembulatan'];
$iptw   		=$_POST['iptw'];
$tgl_toleransi		=$_POST['tgl_toleransi'];

	$input	= "UPDATE $table SET 	def_jasa='$def_jasa',
									def_jangka='$def_jangka',
									pembulatan='$pembulatan',
									iptw='$iptw',
									tgl_toleransi='$tgl_toleransi'
					WHERE id= '$id_kec'";
	mysql_query($input);								
	
?>