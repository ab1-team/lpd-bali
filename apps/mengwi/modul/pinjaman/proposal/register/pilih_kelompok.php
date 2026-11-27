<?php session_start();
include "../../../inc/inc.koneksi.php"; 

$view=mysql_query("select *, d.id as id_desa from kecamatan c, desa d, kelompok_$_SESSION[kd_kab] k where c.kd_kec=d.kd_kec and c.id='$_SESSION[lokasi]' and k.lokasi=c.id and k.desa=d.id order by d.id asc"); //KELOMPOK
while($row=mysql_fetch_array($view)){

echo "<option value='$row[id]'>$row[kd_kelompok] $row[nama_desa] | $row[nama_kelompok] /$row[ketua] [$row[id]]</option>";
} ?>