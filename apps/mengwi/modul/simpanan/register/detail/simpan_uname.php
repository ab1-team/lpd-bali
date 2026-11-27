<?php session_start();
include "../../../../inc/inc.koneksi.php";
$table	= "anggota_$_SESSION[kd_kab]";
$id=$_SESSION['ida'];
$unamenew=$_POST['unamenew'];

	$input	= "UPDATE $table SET uname	='$unamenew'
					WHERE id= '$id'";
	mysql_query($input);								
	
?>