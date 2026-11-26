<?php session_start();
include "../../../inc/inc.koneksi.php";

$id_pinj			= $_POST['id_pinj'] ?: '0';
$tgl_verifikasi		= $_POST['tgl_verifikasi'] ?: '0';
$alokasi			= $_POST['alokasi'] ?: '0';
$pros_jasa			= $_POST['pros_jasa'] ?: '0';
$jangka				= $_POST['jangka'] ?: '0';
$sistem				= $_POST['sistem'] ?: '0';
$catatan_verifikasi	= $_POST['catatan_verifikasi'] ?: '0';
$lu					= date('Y-m-d H:i:s') ?: '0';
$user_id			= $_SESSION['id'] ?: '0';

	$input	= "UPDATE pinjaman_kelompok_$_SESSION[kd_kab] SET tgl_verifikasi		='$tgl_verifikasi',
											alokasi				='$alokasi',
											pros_jasa			='$pros_jasa',
											jangka				='$jangka',
											sistem_angsuran		='$sistem',
											catatan_verifikasi	='$catatan_verifikasi',
											`status`				='V',
											lu					='$lu',
											user_id				='$user_id'
						WHERE id= '$id_pinj'";
	mysql_query($input);
	
	$input2	= "UPDATE pinjaman_anggota_$_SESSION[kd_kab] SET tgl_verifikasi		='$tgl_verifikasi',
											pros_jasa			='$pros_jasa',
											jangka				='$jangka',
											sistem_angsuran		='$sistem',
											`status`				='V',
											lu					='$lu',
											user_id				='$user_id'
						WHERE id_pinkel= '$id_pinj' ";
	mysql_query($input2);


?>