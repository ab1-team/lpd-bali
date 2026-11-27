<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="users";
$id_user=$_SESSION['id'];
$unamenew=$_POST['unamenew'];

	$input	= "UPDATE $table SET uname	='$unamenew'
					WHERE id= '$id_user'";
	mysql_query($input);								
	
?>