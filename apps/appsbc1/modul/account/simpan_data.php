<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="users";
$id_user=$_SESSION['id'];

$nik			=$_POST['nik'];
$namadepan		=addslashes($_POST['namadepan']);
$namabelakang	=addslashes($_POST['namabelakang']);
$ins			=$_POST['ins'];
$jk				=$_POST['jk'];
$tempat_lahir	=$_POST['tempat_lahir'];
$tgl_lahir		=$_POST['tgl_lahir'];
$alamat			=$_POST['alamat'];
$hp				=$_POST['hp'];
$pendidikan		=$_POST['pendidikan'];
$sejak			=$_POST['sejak'];

	$input	= "UPDATE $table SET 	nik='$nik',
									namadepan='$namadepan',
									namabelakang='$namabelakang',
									ins='$ins',
									jk='$jk',
									tempat_lahir='$tempat_lahir',
									tgl_lahir='$tgl_lahir',
									alamat='$alamat',
									hp='$hp',
									pendidikan='$pendidikan',
									sejak='$sejak'
					WHERE id= '$id_user'";
	mysql_query($input);								
	
?>