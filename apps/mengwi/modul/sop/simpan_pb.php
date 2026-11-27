<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="kecamatan";
$id_kec=$_SESSION['lokasi'];

$tgl_open		=$_POST['tgl_open'];
$tgl_close		=$_POST['tgl_close'];

	$input	= "UPDATE $table SET 	tgl_open='$tgl_open',
									tgl_close='$tgl_close'
					WHERE id= '$id_kec'";
	mysql_query($input);								
	
?>