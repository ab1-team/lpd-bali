<?php
include "../../inc/inc.koneksi.php";
$table		="desa";
$id_desa=$_POST['id_desa'];
$kd_desa=$_POST['kd_desa'];
$nama_desa=$_POST['nama_desa'];
$kades=$_POST['kades'];
$no_kades=$_POST['no_kades'];
$sekdes=$_POST['sekdes'];
$no_sekdes=$_POST['no_sekdes'];
$ked=$_POST['ked'];
$no_ked=$_POST['no_ked'];
$deskripsi_desa=$_POST['deskripsi_desa'];

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