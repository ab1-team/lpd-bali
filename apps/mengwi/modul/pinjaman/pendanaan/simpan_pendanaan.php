<?php session_start();
include "../../../inc/inc.koneksi.php";

$id_pinj			= $_POST['id_pinj'];
$tgl_dana		= $_POST['tgl_dana'];
$alokasi			= $_POST['alokasi'];
$pros_jasa			= $_POST['pros_jasa'];
$jangka				= $_POST['jangka'];
$sistem				= $_POST['sistem'];
$catatan_verifikasi	= $_POST['catatan_verifikasi'];
$lu					= date('Y-m-d H:i:s');
$user_id			= $_SESSION['id'];

	$input	= "UPDATE pinjaman_kelompok_$_SESSION[kd_kab] SET 	tgl_dana			='$tgl_dana',
																alokasi				='$alokasi',
																pros_jasa			='$pros_jasa',
																jangka				='$jangka',
																sistem_angsuran		='$sistem',
																catatan_verifikasi	='$catatan_verifikasi',
																`status`			='D',
																lu					='$lu',
																user_id				='$user_id'
						WHERE id= '$id_pinj'";
	mysql_query($input);
	
	$input2	= "UPDATE pinjaman_anggota_$_SESSION[kd_kab] SET 	tgl_dana				='$tgl_dana',
																pros_jasa				='$pros_jasa',
																jangka					='$jangka',
																sistem_angsuran			='$sistem',
																`status`				='D',
																lu						='$lu',
																user_id					='$user_id'
										WHERE id_pinkel= '$id_pinj' AND `status`!='L'";
	mysql_query($input2);
	
	$input3	= "UPDATE pinjaman_anggota_$_SESSION[kd_kab] SET 	tgl_dana				='$tgl_dana',
																pros_jasa				='$pros_jasa',
																jangka					='$jangka',
																sistem_angsuran			='$sistem',
																lu						='$lu',
																user_id					='$user_id'
										WHERE id_pinkel= '$id_pinj' AND `status`='L'";
	mysql_query($input3);


?>