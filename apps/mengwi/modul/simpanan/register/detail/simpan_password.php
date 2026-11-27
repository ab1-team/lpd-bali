<?php session_start();
include "../../../../inc/inc.koneksi.php";
$table	= "anggota_$_SESSION[kd_kab]";
$id=$_SESSION['ida'];
$passnew2=$_POST['passnew2'];

	$input	= "UPDATE $table SET pass	='$passnew2'
					WHERE id= '$id'";
	mysql_query($input);								
	
?>