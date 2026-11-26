<?php session_start();
include "../../inc/inc.koneksi.php";

$jenis_mutasi = $_GET['jenis_mutasi'];
$kd_jb		=substr($jenis_mutasi,0,3);	
$mutasi		=substr($jenis_mutasi,4);	

$row=mysql_fetch_array(mysql_query("select * from jenis_buku WHERE kd_jb='$kd_jb' AND lokasi='$_SESSION[lokasi]' "));
															
$kel = mysql_query("select * from rekening_$_SESSION[lokasi] WHERE kd_jb='$kd_jb' AND jenis_mutasi='$mutasi' ORDER BY kd_rekening ASC ");
echo "<option value=''>-- $row[nama_jb] : $mutasi --</option>";
while($k = mysql_fetch_array($kel)){
     echo "<option value='$k[kd_rekening]'>$k[kd_rekening]. $k[nama_rekening]</option>";
}
?>
