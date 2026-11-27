<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="kecamatan";
$id_kec=$_SESSION['lokasi'];

$n_asur			=$_POST['n_asur'];
$a_premi		=$_POST['a_premi'];
$j_a		=$_POST['j_a'];
$u_max		=$_POST['u_max'];

	$input	= "UPDATE $table SET 	nama_asuransi_p='$n_asur',
									besar_premi='$a_premi',
									usia_mak='$u_max',
									pengaturan_asuransi='$j_a'
					WHERE id= '$id_kec'";
	mysql_query($input);								
	
?>