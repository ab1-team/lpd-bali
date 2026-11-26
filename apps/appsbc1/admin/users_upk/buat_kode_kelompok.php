<?php session_start();
include "../../inc/inc.koneksi.php";
$table	= 'desa';
$id		= $_POST['cari'];
$text	= "SELECT *
			FROM $table WHERE id= '$id'";
$sql 	= mysql_query($text);
$row	= mysql_num_rows($sql);
if ($row>0){
while ($r=mysql_fetch_array($sql)){
	$kd_lokasi	=$_SESSION['lokasi'];
	$id_desa= $r['id'];
	
	$rek=$r['lastregkdkel']+1;
	if ($id_desa < 10){
		$kd_desa='000'.$id_desa;	//009
	}else if ($id_desa >= 10 and $id_desa < 100){
		$kd_desa='00'.$id_desa;	//0099
	}else if ($id_desa >= 100 and $id_desa < 1000){
		$kd_desa='0'.$id_desa;	//0999
	}else if ($id_desa >= 1000 and $id_desa < 10000){
		$kd_desa=$id_desa;	//9999
	}
	
	if ($rek < 10){
		$nol='00';	//09
	}else if ($rek >= 10 and $rek < 100){
		$nol='0';	//099
	}else if ($rek >= 100 and $rek < 1000){
		$nol='';	//999
	}
	
	$data['kd_kelompok']		= $kd_lokasi.$kd_desa.$nol.$rek;	
	echo json_encode($data);
	
}
}else{
	$data['kd_kelompok']		= '';
	echo json_encode($data);
}
?>