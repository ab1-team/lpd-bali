<?php session_start();
include "../../inc/inc.koneksi.php";
$table	= "kelompok_$_SESSION[kd_kab]";

$id						=$_POST['id'];
$namakelompok			=addslashes($_POST['namakelompok']);
$alamatkelompok			=$_POST['alamatkelompok'];
$telepon				=$_POST['telepon'];
$tglberdiri				=$_POST['tglberdiri'];
$jenis_produk_pinjaman	=$_POST['jenis_produk_pinjaman2'];
$jenis_usaha			=$_POST['jenis_usaha2'];
$jenis_kegiatan			=$_POST['jenis_kegiatan2'];
$tingkat_kelompok		=$_POST['tingkat_kelompok2'];
$fungsi_kelompok		=$_POST['fungsi_kelompok2'];
$namaketua				=addslashes($_POST['namaketua']);
$namasek				=addslashes($_POST['namasek']);
$id_user				=$_SESSION['id'];
$lo						=date('Y-m-d H:i:s');


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
								lo						='$lo',
								id_user					='$id_user'
								WHERE id= '$id'";
	mysql_query($update);
	
?>