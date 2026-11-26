<?php
include "../../inc/inc.koneksi.php";
$table		="desa";
$id_desa=$_POST['id_desa'] ?: 0;
$kd_desa=$_POST['kd_desa'] ?: 0;
$nama_desa=$_POST['nama_desa'] ?: 0;
$alamat_desa=$_POST['alamat_desa'] ?: 0;
$telp_desa=$_POST['telp_desa'] ?: 0;
$sebutan=$_POST['sebutan'] ?: 0;
$kades=$_POST['kades'] ?: 0;
$pangkat=$_POST['pangkat'] ?: 0;
$nip=$_POST['nip'] ?: 0;
$no_kades=$_POST['no_kades'] ?: 0;
$sekdes=$_POST['sekdes'] ?: 0;
$no_sekdes=$_POST['no_sekdes'] ?: 0;
$ked=$_POST['ked'] ?: 0;
$no_ked=$_POST['no_ked'] ?: 0;
$deskripsi_desa=$_POST['deskripsi_desa'] ?: 0;
$jadwal_angsuran_desa=$_POST['jadwal_angsuran_desa'] ?: 0;
$uname=$_POST['uname'] ?: 0;
$pass=$_POST['pass'] ?: 0;

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