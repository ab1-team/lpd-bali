<?php session_start();
include "../../../inc/inc.koneksi.php";

$id_pinj			= $_POST['idl'] ?: null;
$tgl_verifikasi		= "0000-00-00" ?: null;
$lu					= date('Y-m-d H:i:s') ?: null;
$user_id			= $_SESSION['id'] ?: null;

	$input	= "UPDATE pinjaman_kelompok_$_SESSION[kd_kab] SET tgl_verifikasi		='$tgl_verifikasi',
															`status`				='P',
															lu					='$lu',
															user_id				='$user_id'
							WHERE id= '$id_pinj'";
	mysql_query($input);
	
	$input2	= "UPDATE pinjaman_anggota_$_SESSION[kd_kab] SET tgl_verifikasi		='$tgl_verifikasi',
																`status`				='P',
																lu					='$lu',
																user_id				='$user_id'
						WHERE id_pinkel= '$id_pinj' ";
	mysql_query($input2);


?>