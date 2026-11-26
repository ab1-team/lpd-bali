<?php
include "../../inc/inc.koneksi.php";
$table	= 'jenis_kas';
$kd_kas	= $_POST['kd_kas'];
$text	= "SELECT *
			FROM $table WHERE kd_kas= '$kd_kas'";
$sql 	= mysql_query($text);
$row	= mysql_num_rows($sql);
if ($row>0){
while ($r=mysql_fetch_array($sql)){
	
	$data['kd_kas']		= $r[kd_kas];
	$data['nama_kas']	= $r[nama_kas];
	$data['deskripsi']		= $r[deskripsi];
	
	echo json_encode($data);
}
}else{
	$data['kd_kas']		= $r[kd_kas];
	$data['nama_kas']		= $r[nama_kas];
	$data['deskripsi']		= $r[deskripsi];

	echo json_encode($data);
	
}
?>