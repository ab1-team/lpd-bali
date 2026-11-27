<?php session_start();
include "../../../inc/inc.koneksi.php";





$jenis_laporan	=$_POST['report'];
$sub_laporan	=$_POST['sub_report'];
$format			=$_POST['format'];



if (empty($sub_laporan)) {
	$file	=$jenis_laporan;
}else{
	$file	=substr($sub_laporan,0,2);
}

if (substr($jenis_laporan,0,2)=="PS") {
	$file	="PS";
}

if($format=='excel'){
	include "../../../modul/pelaporan/master_excel.php";
}else{
	include "../../../modul/pelaporan/$format/$file.php";
}


											
?>