<?php session_start();
include "../../inc/inc.koneksi.php";
$table	= "kelompok_$_SESSION[kd_kab]";

$id						=$_POST['id'] ?: 0;
$namakelompok			=addslashes($_POST['namakelompok']) ?: 0;
$alamatkelompok			=$_POST['alamatkelompok'] ?: 0;
$telepon				=$_POST['telepon'] ?: 0;
$tglberdiri				=$_POST['tglberdiri'] ?: 0;
$jenis_produk_pinjaman	=$_POST['jenis_produk_pinjaman2'] ?: 0;
$jenis_usaha			=$_POST['jenis_usaha2'] ?: 0;
$jenis_kegiatan			=$_POST['jenis_kegiatan2'] ?: 0;
$tingkat_kelompok		=$_POST['tingkat_kelompok2'] ?: 0;
$fungsi_kelompok		=$_POST['fungsi_kelompok2'] ?: 0;
$namaketua				=addslashes($_POST['namaketua']) ?: 0;
$namasek				=addslashes($_POST['namasek']) ?: 0;
$namaben				=addslashes($_POST['namaben']) ?: 0;
$id_user				=$_SESSION['id'] ?: 0;
$lo						=date('Y-m-d H:i:s') ?: 0;


	$update	= "UPDATE $table SET nama_kelompok			='$namakelompok',
								alamat_kelompok='$alamatkelompok',
								telpon					='$telepon',
								tgl_berdiri				='$tglberdiri',
								jenis_produk_pinjaman	='$jenis_produk_pinjaman',
								jenis_usaha				='$jenis_usaha',
								jenis_kegiatan			='$jenis_kegiatan',
								tingkat_kelompok		='$tingkat_kelompok',
								fungsi_kelompok			='$fungsi_kelompok',
								ketua					='$namaketua',
								sekretaris				='$namasek',
								bendahara				='$namaben',
								lo						='$lo',
								id_user					='$id_user'
								WHERE id= '$id'";
	mysql_query($update);
	
?>