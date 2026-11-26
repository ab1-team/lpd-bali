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
	
	$data['id_desa']		= $r['id'];
	$data['kd_desa']		= $r['kd_desa'];
	$data['nama_desa']		= $r['nama_desa'];
	$data['alamat_desa']	= $r['alamat_desa'];
	$data['telp_desa']	    = $r['telp_desa'];
	$data['sebutan']		= $r['sebutan'];
	$data['kades']			= $r['kades'];
	$data['pangkat']		= $r['pangkat'];
	$data['nip']			= $r['nip'];
	$data['no_kades']		= $r['no_kades'];
	$data['sekdes']			= $r['sekdes'];
	$data['no_sekdes']		= $r['no_sekdes'];
	$data['ked']			= $r['ked'];
	$data['no_ked']			= $r['no_ked'];
	$data['deskripsi_desa']		= $r['deskripsi_desa'];
	$data['jadwal_angsuran_desa']		= $r['jadwal_angsuran_desa'];
	$data['uname']		= $r['uname'];
	$data['pass']		= $r['pass'];
	
	echo json_encode($data);
}
}else{
	$data['id_desa']		= $r['id'];
	$data['kd_desa']		= $r['kd_desa'];
	$data['nama_desa']		= $r['nama_desa'];
	$data['alamat_desa']	= $r['alamat_desa'];
	$data['telp_desa']	    = $r['telp_desa'];
	$data['sebutan']		= $r['sebutan'];
	$data['kades']			= $r['kades'];
	$data['pangkat']		= $r['pangkat'];
	$data['nip']			= $r['nip'];
	$data['no_kades']		= $r['no_kades'];
	$data['sekdes']			= $r['sekdes'];
	$data['no_sekdes']		= $r['no_sekdes'];
	$data['ked']			= $r['ked'];
	$data['no_ked']			= $r['no_ked'];
	$data['deskripsi_desa']		= $r['deskripsi_desa'];
	$data['jadwal_angsuran_desa']		= $r['jadwal_angsuran_desa'];
	$data['uname']		= $r['uname'];
	$data['pass']		= $r['pass'];

	echo json_encode($data);
	
}
?>