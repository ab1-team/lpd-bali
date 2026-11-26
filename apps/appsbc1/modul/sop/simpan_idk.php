<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="desa";

$kd_desa			=$_POST['kd_desa'];
$nama_desa		=$_POST['nama_desa'];
$nomor_bh		=$_POST['nomor_bh'];
$alamat_desa		=$_POST['alamat_desa'];
$telpon_desa		=$_POST['telpon_desa'];
$email_desa		=$_POST['email_desa'];
$tagline		=$_POST['tagline'];

	$input	= "UPDATE $table SET 	kd_desa='$kd_desa',
									nama_desa='$nama_desa',
									nomor_bh='$nomor_bh',
									alamat_desa='$alamat_desa',
									telpon_desa='$telpon_desa',
									email_desa='$email_desa',
									tagline='$tagline'
					WHERE kd_desa= '$kd_desa'";
	mysql_query($input);								
	
?>
