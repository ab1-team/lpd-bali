<?php session_start();
include "../../../inc/inc.koneksi.php";

$lokasi				=$_SESSION[lokasi];
$table_transaksi	="transaksi_".$_SESSION[lokasi];
$idf				=$_GET['idf'];
$d					=$_GET['d'];
$m					=$_GET['m'];
$y					=$_GET['y'];
$tgl				="$y-$m-$d";
$row=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan where id='$lokasi' "));
$r=mysql_fetch_array(mysql_query("SELECT * FROM jenis_buku where kd_jb='$idf' "));
$namakec	="_".$row ['nama_kec']."_";
$namabuku	="_".$r ['ins']."_";

if($d=$d){$laporan="D_"; $per="$d-$m-$y";}else if($m=$m){$laporan="M_"; $per="$m-$y";}else if($y=$y){$laporan="Y_"; $per="$y";}else{$laporan="A_";}

$file=$_GET['file'];

$file_name="$file$namabuku$namakec$laporan$per";
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=$file_name.xls");
 
// Tambahkan table
include "$file.php";
?>