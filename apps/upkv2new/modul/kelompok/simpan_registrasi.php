<?php session_start();
include "../../inc/inc.koneksi.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
$table	= "kelompok_$_SESSION[kd_kab]";

$lokasi					=$_POST['lokasi'] ?: 0;
$desa					=$_POST['desa'] ?: 0;
$kd_kelompok			=$_POST['kd_kelompok'] ?: 0;
$nama_kelompok			=addslashes($_POST['nama_kelompok']) ?: 0;
$alamat_kelompok		=$_POST['alamat_kelompok'] ?: 0;
$telpon					=$_POST['telpon'] ?: 0;
$tgl_berdiri			=$_POST['tgl_berdiri'] ?: 0;
$jenis_produk_pinjaman	=$_POST['jenis_produk_pinjaman'] ?: 0;
$jenis_usaha			=$_POST['jenis_usaha'] ?: 0;
$jenis_kegiatan			=$_POST['jenis_kegiatan'] ?: 0;
$tingkat_kelompok		=$_POST['tingkat_kelompok'] ?: 0;
$fungsi_kelompok		=$_POST['fungsi_kelompok'] ?: 0;
$ketua					=addslashes($_POST['ketua']) ?: 0;
$sekretaris				=addslashes($_POST['sekretaris']) ?: 0;
$bendahara				=addslashes($_POST['bendahara']) ?: 0;
$id_user				=$_POST['id_user'] ?: 0;
$pass					="1234" ?: 0;
$lo						=date('Y-m-d H:i:s') ?: 0;

$datadesa=mysql_fetch_array(mysql_query("select * from desa where id='$desa'"));
$noreg	=$datadesa['lastregkdkel']+1;



	$input = "INSERT INTO $table (id,lokasi,desa,kd_kelompok,nama_kelompok,alamat_kelompok,telpon,tgl_berdiri,jenis_produk_pinjaman,jenis_usaha,
								jenis_kegiatan,tingkat_kelompok,fungsi_kelompok,ketua,sekretaris,bendahara,uname,pass,lo,id_user)
						VALUES(null,'$lokasi','$desa','$kd_kelompok','$nama_kelompok','$alamat_kelompok','$telpon','$tgl_berdiri','$jenis_produk_pinjaman',
								'$jenis_usaha','$jenis_kegiatan','$tingkat_kelompok','$fungsi_kelompok','$ketua','$sekretaris','$bendahara','$kd_kelompok','$pass','$lo','$id_user')";
	mysql_query($input);

	
	$update	= "UPDATE desa SET lastregkdkel='$noreg' WHERE id= '$desa'";
	mysql_query($update);
	
?>