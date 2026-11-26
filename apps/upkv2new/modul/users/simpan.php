<?php
include "../../inc/inc.koneksi.php";
$table		="desa";
$id_desa=$_POST['id_desa'] ?: '0';
$kd_desa=$_POST['kd_desa'] ?: '0';
$nama_desa=$_POST['nama_desa'] ?: '0';
$kades=$_POST['kades'] ?: '0';
$no_kades=$_POST['no_kades'] ?: '0';
$sekdes=$_POST['sekdes'] ?: '0';
$no_sekdes=$_POST['no_sekdes'] ?: '0';
$ked=$_POST['ked'] ?: '0';
$no_ked=$_POST['no_ked'] ?: '0';
$deskripsi_desa=$_POST['deskripsi_desa'] ?: '0';

$sql = mysql_query("SELECT *
				   FROM $table 
				   WHERE id= '$id_desa'");
$row	= mysql_num_rows($sql);
if ($row>0){
	$input	= "UPDATE $table SET id	='$id_desa',
								kd_desa='$kd_desa',
								nama_desa='$nama_desa',
								kades='$kades',
								no_kades='$no_kades',
								sekdes='$sekdes',
								no_sekdes='$no_sekdes',
								ked='$ked',
								no_ked='$no_ked',
								deskripsi_desa='$deskripsi_desa'
					WHERE id= '$id_desa'";
	mysql_query($input);								
}
?>