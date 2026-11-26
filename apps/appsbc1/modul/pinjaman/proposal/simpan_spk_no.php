<?php session_start();
include "../../../inc/inc.koneksi.php";
$table		="pinjaman_kelompok_$_SESSION[kd_kab]";

$spk_no		= $_POST['spk_no'];
$idpinj		= $_POST['idpinj'];
$waktu		= $_POST['waktu'];
$tempat		= $_POST['tempat'];

$wt_cair=$waktu."_".$tempat;


	$update	= "UPDATE $table SET spk_no='$spk_no', wt_cair='$wt_cair' WHERE id= '$idpinj'  ";
	mysql_query($update);					


	
?>