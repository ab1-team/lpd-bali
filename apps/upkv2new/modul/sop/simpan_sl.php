<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="kecamatan";
$id_kec=$_SESSION['lokasi'];

$nama_lembaga_sort	=$_POST['nama_lembaga_sort'] ?: '0';
$nama_lembaga_long	=$_POST['nama_lembaga_long'] ?: '0';
$nama_bkad_sort		=$_POST['nama_bkad_sort'] ?: '0';
$nama_bkad_long		=$_POST['nama_bkad_long'] ?: '0';
$nama_bp_sort		=$_POST['nama_bp_sort'] ?: '0';
$nama_bp_long		=$_POST['nama_bp_long'] ?: '0';
$nama_tv_sort		=$_POST['nama_tv_sort'] ?: '0';
$nama_tv_long		=$_POST['nama_tv_long'] ?: '0';


	$input	= "UPDATE $table SET 	nama_lembaga_sort='$nama_lembaga_sort',
									nama_lembaga_long='$nama_lembaga_long',
									nama_bkad_sort='$nama_bkad_sort',
									nama_bkad_long='$nama_bkad_long',
									nama_bp_sort='$nama_bp_sort',
									nama_bp_long='$nama_bp_long',
									nama_tv_sort='$nama_tv_sort',
									nama_tv_long='$nama_tv_long'
					WHERE id= '$id_kec'";
	mysql_query($input);								
	
?>