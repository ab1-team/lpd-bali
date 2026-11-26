<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="kecamatan";
$id_kec=$_SESSION['lokasi'];

$def_jasa			=$_POST['def_jasa'] ?: '0';
$def_jangka		=$_POST['def_jangka'] ?: '0';
$pembulatan		=$_POST['pembulatan'] ?: '0';
$iptw   		=$_POST['iptw'] ?: '0';
$tgl_toleransi		=$_POST['tgl_toleransi'] ?: '0';

	$input	= "UPDATE $table SET 	def_jasa='$def_jasa',
									def_jangka='$def_jangka',
									pembulatan='$pembulatan',
									iptw='$iptw',
									tgl_toleransi='$tgl_toleransi'
					WHERE id= '$id_kec'";
	mysql_query($input);								
	
?>