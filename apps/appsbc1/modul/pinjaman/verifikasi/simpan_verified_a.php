<?php session_start();
include "../../../inc/inc.koneksi.php";

$idpa				= $_POST['idpa'];
$_SESSION['idpinj']	= $_POST['idpinj'];
$alokasia			= $_POST['alokasia'];
$catatan_anggota	= $_POST['catatan_anggota'];
	
	$input2	= "UPDATE pinjaman_anggota_$_SESSION[kd_kab] SET 
															alokasi	='$alokasia',
															catatan_verifikasi	='$catatan_anggota'
						WHERE id='$idpa' ";
	mysql_query($input2);


?>