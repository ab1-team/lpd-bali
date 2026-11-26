<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="users";
$id_user=$_SESSION['id'];

$nik			=$_POST['nik'] ?: 0;
$namadepan		=addslashes($_POST['namadepan']) ?: 0;
$namabelakang	=addslashes($_POST['namabelakang']) ?: 0;
$ins			=$_POST['ins'] ?: 0;
$jk				=$_POST['jk'] ?: 0;
$tempat_lahir	=$_POST['tempat_lahir'] ?: 0;
$tgl_lahir		=$_POST['tgl_lahir'] ?: 0;
$alamat			=$_POST['alamat'] ?: 0;
$hp				=$_POST['hp'] ?: 0;
$pendidikan		=$_POST['pendidikan'] ?: 0;
$sejak			=$_POST['sejak'] ?: 0;

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