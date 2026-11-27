<?php session_start();
include "../../inc/inc.koneksi.php";

$id_pinj			= $_POST['id_pinj'];
$tgl_verifikasi		= $_POST['tgl_verifikasi'];
$alokasi			= $_POST['alokasi'];
$pros_jasa			= $_POST['pros_jasa'];
$jangka				= $_POST['jangka'];
$catatan_verifikasi	= $_POST['catatan_verifikasi'];
$lu					= date('Y-m-d H:i:s');
$user_id			= $_SESSION['id'];

	
	$input2	= "UPDATE pinjaman_anggota_$_SESSION[kd_kab] SET tgl_verifikasi		='$tgl_verifikasi',
											alokasi			='$alokasi',
											pros_jasa			='$pros_jasa',
											jangka				='$jangka',
											catatan_verifikasi		='$catatan_verifikasi',
											`status`				='V',
											lu					='$lu',
											user_id				='$user_id'
						WHERE id= '$id_pinj' AND jenis_pinjaman='T' ";
	mysql_query($input2);


?>