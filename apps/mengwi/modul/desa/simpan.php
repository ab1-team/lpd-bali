<?php
include "../../inc/inc.koneksi.php";
$table		="desa";
$id_desa=$_POST['id_desa'];
$kd_desa=$_POST['kd_desa'];
$nama_desa=$_POST['nama_desa'];
$alamat_desa=$_POST['alamat_desa'];
$telp_desa=$_POST['telp_desa'];
$sebutan=$_POST['sebutan'];
$kades=$_POST['kades'];
$pangkat=$_POST['pangkat'];
$nip=$_POST['nip'];
$no_kades=$_POST['no_kades'];
$sekdes=$_POST['sekdes'];
$no_sekdes=$_POST['no_sekdes'];
$ked=$_POST['ked'];
$no_ked=$_POST['no_ked'];
$deskripsi_desa=$_POST['deskripsi_desa'];
$jadwal_angsuran_desa=$_POST['jadwal_angsuran_desa'];
$uname=$_POST['uname'];
$pass=$_POST['pass'];

$sql = mysql_query("SELECT *
				   FROM $table 
				   WHERE id= '$id_desa'");
$row	= mysql_num_rows($sql);
if ($row>0){
	$input	= "UPDATE $table SET id	='$id_desa',
								kd_desa='$kd_desa',
								nama_desa='$nama_desa',
								alamat_desa='$alamat_desa',
								telp_desa='$telp_desa',
								sebutan='$sebutan',
								kades='$kades',
								pangkat='$pangkat',
								nip='$nip',
								no_kades='$no_kades',
								sekdes='$sekdes',
								no_sekdes='$no_sekdes',
								ked='$ked',
								no_ked='$no_ked',
								deskripsi_desa='$deskripsi_desa',
								jadwal_angsuran_desa='$jadwal_angsuran_desa',
								uname='$uname',
								pass='$pass'
					WHERE id= '$id_desa'";
	mysql_query($input);								
}
?>