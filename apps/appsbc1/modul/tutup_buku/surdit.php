<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_keuangan.php";

$tgl_kondisi		="$_SESSION[tahunbuku]-12-31";

$saldo_kelembagaan	=saldo("$tgl_kondisi-211")*-1;
$saldo_dansos		=saldo("$tgl_kondisi-212")*-1;
$saldo_bonus		=saldo("$tgl_kondisi-213")*-1;
$saldo_lain			=saldo("$tgl_kondisi-214")*-1;
$saldo_cadanganresiko=saldo("$tgl_kondisi-215")*-1;

$data1	=mysql_fetch_array(mysql_query("SELECT *, tb$_SESSION[tahunbuku] as dataview FROM rekening_$_SESSION[lokasi] WHERE kd_rekening='211.01' "));
$kelembagaan	=$data1['dataview'];

$data2	=mysql_fetch_array(mysql_query("SELECT *, tb$_SESSION[tahunbuku] as dataview FROM rekening_$_SESSION[lokasi] WHERE kd_rekening='212.01' "));
$dansos	=$data2['dataview'];

$data3	=mysql_fetch_array(mysql_query("SELECT *, tb$_SESSION[tahunbuku] as dataview FROM rekening_$_SESSION[lokasi] WHERE kd_rekening='213.01' "));
$bonus	=$data3['dataview'];

$data4	=mysql_fetch_array(mysql_query("SELECT *, tb$_SESSION[tahunbuku] as dataview FROM rekening_$_SESSION[lokasi] WHERE kd_rekening='214.01' "));
$lainnya	=$data4['dataview'];

$data5	=mysql_fetch_array(mysql_query("SELECT *, tb$_SESSION[tahunbuku] as dataview FROM rekening_$_SESSION[lokasi] WHERE kd_rekening='215.01' "));
$cadanganresiko	=$data5['dataview'];

$tambah=	$_SESSION['surplus_kotor']-($kelembagaan+$dansos+$bonus+$lainnya+$cadanganresiko)+($saldo_kelembagaan+$saldo_dansos+$saldo_bonus+$saldo_lain+$saldo_cadanganresiko);

$surdit	=	$_SESSION['surdit']+$tambah;

echo "<input type='text' class='form-control text-align-right' id='ditahan' name='ditahan' value='$surdit' disabled>";

?>