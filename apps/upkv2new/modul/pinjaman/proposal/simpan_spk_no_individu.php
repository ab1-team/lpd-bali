<?php session_start();
include "../../../inc/inc.koneksi.php";
$table		="pinjaman_anggota_$_SESSION[kd_kab]";

$spk_no		= $_POST['spk_no'] ?: '0';
$idpinj		= $_POST['idpinj'] ?: '0';


	$update	= "UPDATE $table SET spk_no='$spk_no' WHERE id= '$idpinj'  ";
	mysql_query($update);					


	
?>