<?php session_start();
include "../../../inc/inc.koneksi.php";

$id_pinj	= $_POST['id_pinj'] ?: '0';
$tgl_cair	= $_POST['tgl_cair'] ?: '0';
$tgl_tunggu	= date('Y-m-d') ?: '0';
$lu			= date('Y-m-d H:i:s') ?: '0';
$user_id	= $_SESSION['id'] ?: '0';


	$input2	= "UPDATE pinjaman_anggota_$_SESSION[kd_kab] SET tgl_tunggu	='$tgl_tunggu',
											tgl_cair	='$tgl_cair',
											`status`		='W',
											lu			='$lu',
											user_id		='$user_id'
						WHERE id= '$id_pinj'";
	mysql_query($input2);

?>