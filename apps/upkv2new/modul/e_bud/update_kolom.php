<?php session_start(); 
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_keuangan.php";
$table					="rekening_$_SESSION[lokasi]";
$tahun_anggaran			=$_POST['tahun_anggaran'];
$baris					=$_POST['baris'];
$kolom					="ra_$tahun_anggaran";
$kd_rekening			=$_POST['kd_rekening'];
$_SESSION['tahun_anggaran']	=$_POST['tahun_anggaran'];

		
	$input1	= "UPDATE $table SET $kolom ='$baris'
					WHERE kd_rekening ='$kd_rekening' ";
	mysql_query($input1);


?>