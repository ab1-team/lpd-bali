<?php session_start();
include "../../../inc/inc.koneksi.php";
$table	= "anggota_$_SESSION[kd_kab]";
$id=$_SESSION['ida'];
$alamatnew=$_POST['alamatnew'];
$desanew=$_POST['desanew'];

	$input	= "UPDATE $table SET 	alamat	='$alamatnew',
									desa	='$desanew'
					WHERE id= '$id'";
	mysql_query($input);								
	
?>