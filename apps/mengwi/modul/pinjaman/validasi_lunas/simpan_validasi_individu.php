<?php session_start();
include "../../../inc/inc.koneksi.php";

$id_pinj			= $_POST['idp'];
$tgl_lunas			= date('Y-m-d');
$lu					= date('Y-m-d H:i:s');
$user_id			= $_SESSION['id'];

	
	$input2	= "UPDATE pinjaman_anggota_$_SESSION[kd_kab] SET 	tgl_lunas		='$tgl_lunas',
											`status`				='L',
											lu					='$lu',
											user_id				='$user_id'
						WHERE id= '$id_pinj' ";
	mysql_query($input2);


?>