<?php session_start();
include "../../../inc/inc.koneksi.php";
$table		="pinjaman_anggota_$_SESSION[kd_kab]";

$id_pinj_i			= $_POST['id_pinj_i'];
$status				= $_POST['status'];
$keputusan			= $_POST['keputusan'];

$tgl_rekomendasi		= $_POST['tgl_rekomendasi'];
$proposali				= str_replace(".", "", $_POST['maksimum_kredit']);
$jangka					= $_POST['jangka_waktu'];
$pros_jasa				= $_POST['prosentase_jasa'];
$jenis_jasa				= $_POST['jenis_bunga'];
$sistem					= $_POST['sa_pokok'];
$sa_jasa				= $_POST['sa_bunga'];
$tujuan_penggunaan		= $_POST['tujuan_penggunaan'];
$nilai_jaminan			= str_replace(".", "", $_POST['nilai_jaminan']);
$catatan_rekomendasi	= $_POST['catatan_rekomendasi'];
$lu						= date('Y-m-d H:i:s');
$user_id				= $_SESSION['id'];

if ($keputusan=="setuju") {
	if ($_SESSION['level']=="1" AND $_SESSION['jabatan']=="4" AND $status=="P") { //Analis
		$status_to	= "V1";
		$field		= "data_verifikasi_analis";
	}else if ($_SESSION['level']=="1" AND $_SESSION['jabatan']=="1" AND $status=="V1") { //Kepala
		$status_to	= "V2";
		$field		= "data_verifikasi_kepala";
	}else if ($_SESSION['level']=="3" AND $status=="V2") { //BaWas
		$status_to	= "V3";
		$field		= "data_verifikasi_bawas";
	}
}else if ($keputusan=="kembali") {
	if ($_SESSION['level']=="1" AND $_SESSION['jabatan']=="4" AND $status=="P") { //Analis
		$status_to	= "P";
		$field		= "data_verifikasi_analis";
	}else if ($_SESSION['level']=="1" AND $_SESSION['jabatan']=="1" AND $status=="V1") { //Kepala
		$status_to	= "P";
		$field		= "data_verifikasi_kepala";
	}else if ($_SESSION['level']=="3" AND $status=="V2") { //BaWas
		$status_to	= "V1";
		$field		= "data_verifikasi_bawas";
	}
}else if ($keputusan=="tidak_setuju") {
	if ($_SESSION['level']=="1" AND $_SESSION['jabatan']=="4" AND $status=="P") { //Analis
		$status_to	= "TL";
		$field		= "data_verifikasi_analis";
	}else if ($_SESSION['level']=="1" AND $_SESSION['jabatan']=="1" AND $status=="V1") { //Kepala
		$status_to	= "TL";
		$field		= "data_verifikasi_kepala";
	}else if ($_SESSION['level']=="3" AND $status=="V2") { //BaWas
		$status_to	= "TL";
		$field		= "data_verifikasi_bawas";
	}
}




$data_verifikasi	="$tgl_rekomendasi#$proposali#$jangka#$pros_jasa#$jenis_jasa#$sistem#$sa_jasa#$tujuan_penggunaan#$user_id#$nilai_jaminan#$catatan_rekomendasi";


$row = mysql_num_rows(mysql_query("SELECT * FROM $table WHERE id= '$id_pinj_i'"));

if ($row>0){
	
			$update	= "UPDATE $table SET 	$field					='$data_verifikasi',
											alokasi					='$proposali',
											jangka					='$jangka',
											pros_jasa				='$pros_jasa',
											jenis_jasa				='$jenis_jasa',
											sistem_angsuran			='$sistem',
											sa_jasa					='$sa_jasa',
											status					='$status_to',
											lu						='$lu',
											user_id					='$user_id'
						WHERE id='$id_pinj_i' ";
	mysql_query($update);
	
}
?>