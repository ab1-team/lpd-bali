<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="kecamatan";
$id_kec=$_SESSION['lokasi'];

$redaksi_spk			=$_POST['redaksi_spk'] ?: '0';

	$input	= "UPDATE $table SET 	redaksi_spk='$redaksi_spk'
	
					WHERE id= '$id_kec'";
	mysql_query($input);								
	
?>