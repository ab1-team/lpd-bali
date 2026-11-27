<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="users";
$id_user=$_SESSION['id'];
$mutiara=$_POST['mutiara'];

	$input	= "UPDATE $table SET mutiara	='$mutiara'
					WHERE id= '$id_user'";
	mysql_query($input);								
	
?>