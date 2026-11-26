<?php session_start();
include "../../../inc/inc.koneksi.php";

$id_pinj	= $_POST['id_pinj_i_dt'];
$tgl_cair	= $_POST['tgl_cair'];
$tgl_tunggu	= date('Y-m-d');
$lu			= date('Y-m-d H:i:s');
$user_id	= $_SESSION['id'];
$data_waiting	="$tgl_cair#$user_id";

	$input2	= "UPDATE pinjaman_anggota_$_SESSION[kd_kab] SET data_waiting	='$data_waiting',
											tgl_cair	='$tgl_cair',
											`status`		='W',
											lu			='$lu',
											user_id		='$user_id'
						WHERE id= '$id_pinj'";
	mysql_query($input2);

?>