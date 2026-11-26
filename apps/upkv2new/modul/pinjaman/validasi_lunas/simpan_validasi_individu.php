<?php session_start();
include "../../../inc/inc.koneksi.php";

$id_pinj			= $_POST['idp'] ?: '0';
$tgl_lunas			= date('Y-m-d') ?: '0';
$lu					= date('Y-m-d H:i:s') ?: '0';
$user_id			= $_SESSION['id'] ?: '0';

	
	$input2	= "UPDATE pinjaman_anggota_$_SESSION[kd_kab] SET 	tgl_lunas		='$tgl_lunas',
											`status`				='L',
											lu					='$lu',
											user_id				='$user_id'
						WHERE id= '$id_pinj' ";
	mysql_query($input2);


?>