<?php session_start(); 
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_keuangan_admin.php";
$table					="admin_rekening";
$tahunbuku				=$_POST['tahunbuku'];
$kolom					="tb$tahunbuku";
$tgl					="$tahunbuku-12-31";


$data=mysql_query("select * from $table ");
	while($r=mysql_fetch_array($data)){
	$no=$no+1;
	
	$kd_rekening	=$r['kd_rekening'];
	$jm				=$r['jenis_mutasi'];
	$saldorekeningD	=saldoDR("$tgl-$r[kd_rekening]");
	$saldorekeningK	=saldoKR("$tgl-$r[kd_rekening]");
		 if($jm=='debit') {$saldorekening=$saldorekeningD;}
	else if($jm=='kredit'){$saldorekening=$saldorekeningK;}
		
	$input1	= "UPDATE $table SET $kolom ='$saldorekening'
					WHERE kd_rekening ='$kd_rekening' AND posisi='1' ";
	mysql_query($input1);
}

?>