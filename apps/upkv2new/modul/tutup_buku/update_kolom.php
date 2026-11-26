<?php session_start(); 
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_keuangan.php";
$table					="rekening_$_SESSION[lokasi]";
$tahunbuku				=$_POST['tahunbuku'];
$kolom					="tb$tahunbuku";
$tgl					="$tahunbuku-12-31";


$data=mysql_query("select * from $table ");
	while($r=mysql_fetch_array($data)){
	$no=$no+1;
	
	$kd_rekening	=$r['kd_rekening'];
	$jm				=$r['jenis_mutasi'];
	$saldorekeningD	=SATDR("$tgl-$kd_rekening")+SABDR("$tgl-$kd_rekening");
	$saldorekeningK	=SATKR("$tgl-$kd_rekening")+SABKR("$tgl-$kd_rekening");
	if($jm=='debit') {$saldorekening=$saldorekeningD;}else{$saldorekening=$saldorekeningK;}
		
	$input1	= "UPDATE $table SET $kolom ='$saldorekening'
					WHERE kd_rekening ='$kd_rekening' AND posisi='1' ";
	mysql_query($input1);
}

?>