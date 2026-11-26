<?php session_start();
include "../../../inc/inc.koneksi.php";





$jenis_laporan	=$_POST['report'];
$sub_laporan	=$_POST['sub_report'];



if (empty($sub_laporan)) {
	$file	=$jenis_laporan;
}else{
	$file	=substr($sub_laporan,0,2);
}


include "../../../modul/pelaporan/pdf/$file.php";



											
?>