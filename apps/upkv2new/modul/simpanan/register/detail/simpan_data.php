<?php session_start();
include "../../../../inc/inc.koneksi.php";
$table	= "anggota_$_SESSION[kd_kab]";
$id=$_SESSION['ida'];

$nik			=$_POST['nik'];
$namadepan		=addslashes($_POST['namadepan']);
$jk				=$_POST['jk'];
$tempat_lahir	=$_POST['tempat_lahir'];
$tgl_lahir		=$_POST['tgl_lahir'];
$alamat			=$_POST['alamat'];
$hp				=$_POST['hp'];
$kk				=$_POST['kk'];
$penjamin		=$_POST['penjamin'];
$hubungan		=$_POST['hubungan'];
$usaha			=$_POST['usaha'];
$petugas		=$_SESSION['id'];
$lo				=date('Y-m-d H:i:s');

	$input	= "UPDATE $table SET 	nik='$nik',
									namadepan='$namadepan',
									jk='$jk',
									tempat_lahir='$tempat_lahir',
									tgl_lahir='$tgl_lahir',
									alamat='$alamat',
									hp='$hp',
									kk='$kk',
									penjamin='$penjamin',
									hubungan='$hubungan',
									usaha='$usaha',
									petugas='$petugas',
									lo='$lo'
					WHERE id= '$id'";
	mysql_query($input);								
	
?>