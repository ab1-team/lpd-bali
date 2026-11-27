<?php
include "../../inc/inc.koneksi.php";
$table	= 'desa';
$id_desa	= $_POST['id_desa'];
$text	= "SELECT *
			FROM $table WHERE id= '$id_desa'";
$sql 	= mysql_query($text);
$row	= mysql_num_rows($sql);
if ($row>0){
while ($r=mysql_fetch_array($sql)){
	
	$data['id_desa']		= $r[id_desa];
	$data['kd_desa']		= $r[kd_desa];
	$data['nama_desa']	= $r[nama_desa];
	$data['kades']		= $r[kades];
	$data['no_kades']		= $r[no_kades];
	$data['sekdes']		= $r[sekdes];
	$data['no_sekdes']		= $r[no_sekdes];
	$data['ked']		= $r[ked];
	$data['no_ked']		= $r[no_ked];
	$data['deskripsi_desa']		= $r[deskripsi_desa];
	
	echo json_encode($data);
}
}else{
	$data['id_desa']		= $r[id_desa];
	$data['kd_desa']		= $r[kd_desa];
	$data['nama_desa']		= $r[nama_desa];
	$data['kades']		= $r[kades];
	$data['no_kades']		= $r[no_kades];
	$data['sekdes']		= $r[sekdes];
	$data['no_sekdes']		= $r[no_sekdes];
	$data['ked']		= $r[ked];
	$data['no_ked']		= $r[no_ked];
	$data['deskripsi_desa']		= $r[deskripsi_desa];

	echo json_encode($data);
	
}
?>