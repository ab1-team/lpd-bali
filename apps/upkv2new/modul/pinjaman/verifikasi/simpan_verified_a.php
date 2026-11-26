<?php session_start();
include "../../../inc/inc.koneksi.php";

$idpa				= $_POST['idpa'] ?: '0';
$_SESSION['idpinj']	= $_POST['idpinj'] ?: '0';
$alokasia			= $_POST['alokasia'] ?: '0';
$catatan_anggota	= $_POST['catatan_anggota'] ?: '0';
	
	$input2	= "UPDATE pinjaman_anggota_$_SESSION[kd_kab] SET 
															alokasi	='$alokasia',
															catatan_verifikasi	='$catatan_anggota'
						WHERE id='$idpa' ";
	mysql_query($input2);


?>