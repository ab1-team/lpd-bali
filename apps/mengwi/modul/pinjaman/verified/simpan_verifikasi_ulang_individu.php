<?php session_start();
include "../../../inc/inc.koneksi.php";

$id_pinj			= $_POST['idl'];
$tgl_verifikasi		= "0000-00-00";
$lu					= date('Y-m-d H:i:s');
$user_id			= $_SESSION['id'];

	
	$input2	= "UPDATE pinjaman_anggota_$_SESSION[kd_kab] SET tgl_verifikasi		='$tgl_verifikasi',
																tgl_tunggu		='0000-00-00',
																tgl_cair		='0000-00-00',
																`status`				='P',
																lu					='$lu',
																user_id				='$user_id'
						WHERE id= '$id_pinj' ";
	mysql_query($input2);


?>