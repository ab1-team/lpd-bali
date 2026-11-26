<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="users";
$id_user=$_SESSION['id'];
$passnew2=$_POST['passnew2'];

	$input	= "UPDATE $table SET pass	='$passnew2'
					WHERE id= '$id_user'";
	mysql_query($input);								
	
?>