<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="kecamatan";
$id_user=$_SESSION['id'];

$kd_kec			=$_POST['kd_kec'];
$nama_kec		=$_POST['nama_kec'];
$nomor_bh		=$_POST['nomor_bh'];
$alamat_kec		=$_POST['alamat_kec'];
$telpon_kec		=$_POST['telpon_kec'];
$email_kec		=$_POST['email_kec'];
$web_kec		=$_POST['web_kec'];
$visi_misi		=$_POST['visi_misi'];

	$input	= "UPDATE $table SET 	kd_kec='$kd_kec',
									nama_kec='$nama_kec',
									nomor_bh='$nomor_bh',
									alamat_kec='$alamat_kec',
									telpon_kec='$telpon_kec',
									email_kec='$email_kec',
									web_kec='$web_kec',
									visi_misi='$visi_misi'
					WHERE kd_kec= '$kd_kec'";
	mysql_query($input);								
	
?>