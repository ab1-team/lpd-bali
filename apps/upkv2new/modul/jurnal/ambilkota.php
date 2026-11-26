<?php session_start();
include "../../inc/inc.koneksi.php";
$jenis_rekening = $_GET['jenis_rekening'];

$row=mysql_fetch_array(mysql_query("select * from rekening_riil WHERE kd_rr='$jenis_rekening' "));

$kota = mysql_query("SELECT * FROM jenis_buku WHERE kd_jr='$jenis_rekening' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%'  AND lokasi='0' or kd_jr='$jenis_rekening' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' order by id");
echo "<option>-- Daftar Buku $row[nama_rr] --</option>";
while($k = mysql_fetch_array($kota)){
     echo "<option value=\"".$k['kd_jb']."\">".$k['nama_jb']."</option>\n";
}
?>
