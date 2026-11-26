<?php session_start();
include "../../../inc/inc.koneksi.php";
$kecamatan = $_GET['kecamatan'];

$row=mysql_fetch_array(mysql_query("select * from kecamatan WHERE id='$kecamatan' "));

$desa = mysql_query("SELECT * FROM desa WHERE kd_kec=$row[kd_kec] order by id");
echo "<option>-- Daftar Desa Kec. $row[nama_kec] --</option>";
while($d = mysql_fetch_array($desa)){
     echo "<option value=\"".$d['id']."\">".$d['nama_desa']."</option>\n";
}
?>
