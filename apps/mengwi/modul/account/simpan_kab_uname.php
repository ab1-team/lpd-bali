<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="kabupaten";
$id=$_SESSION['id'];
$uname=$_POST['uname'];

	$input	= "UPDATE $table SET uname	='$uname'
					WHERE id= '$id'";
	mysql_query($input);								
	
?>