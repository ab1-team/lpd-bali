<?php session_start();
include "../../inc/inc.koneksi.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
$table	= "kelompok_$_SESSION[kd_kab]";

$lokasi					=$_POST['lokasi'];
$desa					=$_POST['desa'];
$kd_kelompok			=$_POST['kd_kelompok'];
$nama_kelompok			=addslashes($_POST['nama_kelompok']);
$alamat_kelompok		=$_POST['alamat_kelompok'];
$telpon					=$_POST['telpon'];
$tgl_berdiri			=$_POST['tgl_berdiri'];
$jenis_produk_pinjaman	=$_POST['jenis_produk_pinjaman'];
$jenis_usaha			=$_POST['jenis_usaha'];
$jenis_kegiatan			=$_POST['jenis_kegiatan'];
$tingkat_kelompok		=$_POST['tingkat_kelompok'];
$fungsi_kelompok		=$_POST['fungsi_kelompok'];
$ketua					=addslashes($_POST['ketua']);
$sekretaris				=addslashes($_POST['sekretaris']);
$bendahara				=addslashes($_POST['bendahara']);
$id_user				=$_POST['id_user'];
$pass					="1234";
$lo						=date('Y-m-d H:i:s');

$datadesa=mysql_fetch_array(mysql_query("select * from desa where id='$desa'"));
$noreg	=$datadesa['lastregkdkel']+1;



	$input = "INSERT INTO $table (id,lokasi,desa,kd_kelompok,nama_kelompok,alamat_kelompok,telpon,tgl_berdiri,jenis_produk_pinjaman,jenis_usaha,
								jenis_kegiatan,tingkat_kelompok,fungsi_kelompok,ketua,sekretaris,bendahara,uname,pass,lo,id_user)
						VALUES('','$lokasi','$desa','$kd_kelompok','$nama_kelompok','$alamat_kelompok','$telpon','$tgl_berdiri','$jenis_produk_pinjaman',
								'$jenis_usaha','$jenis_kegiatan','$tingkat_kelompok','$fungsi_kelompok','$ketua','$sekretaris','$bendahara','$kd_kelompok','$pass','$lo','$id_user')";
	mysql_query($input);

	
	$update	= "UPDATE desa SET lastregkdkel='$noreg' WHERE id= '$desa'";
	mysql_query($update);
	
?>