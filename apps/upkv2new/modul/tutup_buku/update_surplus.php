<?php session_start(); 
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_keuangan.php";
$table			="rekening_$_SESSION[lokasi]";

$tahunbuku		="tb$_SESSION[tahunbuku]";
$kelembagaan	=$_POST['kelembagaan'];
$dansos			=$_POST['dansos'];
$bonus			=$_POST['bonus'];
$lain			=$_POST['lain'];
$ditahan		=$_POST['ditahan'];
$cadanganresiko		=$_POST['cadanganresiko'];

$tgl_kondisi		="$_SESSION[tahunbuku]-12-31";

$saldo_kelembagaan	=saldo("$tgl_kondisi-211")*-1;
$saldo_dansos		=saldo("$tgl_kondisi-212")*-1;
$saldo_bonus		=saldo("$tgl_kondisi-213")*-1;
$saldo_lain			=saldo("$tgl_kondisi-214")*-1;
$saldo_cadanganresiko=saldo("$tgl_kondisi-215")*-1;

$sum_kelembagaan	=$saldo_kelembagaan+$kelembagaan;
$sum_dansos			=$saldo_dansos+$dansos;
$sum_bonus			=$saldo_bonus+$bonus;
$sum_lain			=$saldo_lain+$lain;
$sum_cadanganresiko	=$saldo_cadanganresiko+$cadanganresiko;
								
								

	$input1	= "UPDATE $table SET $tahunbuku='$sum_kelembagaan' 	WHERE kd_rekening='211.01' ";
	mysql_query($input1);
	
	$input2	= "UPDATE $table SET $tahunbuku='$sum_dansos' 		WHERE kd_rekening='212.01' ";
	mysql_query($input2);
	
	$input3	= "UPDATE $table SET $tahunbuku='$sum_bonus' 		WHERE kd_rekening='213.01' ";
	mysql_query($input3);
	
	$input4	= "UPDATE $table SET $tahunbuku='$sum_lain' 		WHERE kd_rekening='214.01' ";
	mysql_query($input4);
	
	$input5	= "UPDATE $table SET $tahunbuku='$ditahan' 		WHERE kd_rekening='316.01' ";
	mysql_query($input5);
	
	
	$input6	= "UPDATE $table SET $tahunbuku='$sum_cadanganresiko' 		WHERE kd_rekening='215.01' ";
	mysql_query($input6);
	
	$input5	= "UPDATE $table SET $tahunbuku='0' 		WHERE kd_rekening='211.02' OR kd_rekening='212.02' OR kd_rekening='213.02' OR kd_rekening='214.02' OR kd_rekening='316.02' ";
	mysql_query($input5);
	

?>