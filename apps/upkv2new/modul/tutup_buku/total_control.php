<?php session_start();
include "../../inc/inc.koneksi.php";


$data1	=mysql_fetch_array(mysql_query("SELECT *, tb$_SESSION[tahunbuku] as dataview1 FROM rekening_$_SESSION[lokasi] WHERE kd_rekening='211.01' "));
$kelembagaan	=$data1['dataview1'];

$data2	=mysql_fetch_array(mysql_query("SELECT *, tb$_SESSION[tahunbuku] as dataview2 FROM rekening_$_SESSION[lokasi] WHERE kd_rekening='212.01' "));
$dansos	=$data2['dataview2'];

$data3	=mysql_fetch_array(mysql_query("SELECT *, tb$_SESSION[tahunbuku] as dataview3 FROM rekening_$_SESSION[lokasi] WHERE kd_rekening='213.01' "));
$bonus	=$data3['dataview3'];

$data4	=mysql_fetch_array(mysql_query("SELECT *, tb$_SESSION[tahunbuku] as dataview4 FROM rekening_$_SESSION[lokasi] WHERE kd_rekening='214.01' "));
$lainnya	=$data4['dataview4'];

$data5	=mysql_fetch_array(mysql_query("SELECT *, tb$_SESSION[tahunbuku] as dataview5 FROM rekening_$_SESSION[lokasi] WHERE kd_rekening='215.01' "));
$cadanganresiko	=$data5['dataview5'];

$modal=	$_SESSION['surplus_bersih']-($kelembagaan+$dansos+$bonus+$lainnya);

$total_control=$modal+$kelembagaan+$dansos+$bonus+$lainnya+$cadanganresiko;

$surplus_kotor=	$_SESSION['surplus_kotor'];

$selisih	=$total_control-$surplus_kotor;

if($selisih==0) {$keterangan="Balance";}else{$keterangan="Selisih ".number_format($selisih);}

echo number_format($total_control);
echo "<br><span style='color:red;'><i>$keterangan</i></span>";


?>