<?php
include "../inc/inc.koneksi.php";

$r=mysql_fetch_array(mysql_query("SELECT c.id id_kecamatan,c.kd_kab FROM kecamatan c join users u ON (c.id=u.lokasi) WHERE u.id=".$_GET['id']));

$arr = array(' -- Pilih Nama Kelompok -- ');
$view=mysql_query("select d.nama_desa,k.nama_kelompok from kecamatan c, desa d, pinjaman_kelompok_".$r['kd_kab']." pk, kelompok_".$r['kd_kab']." k where c.kd_kec=d.kd_kec and k.id=pk.id_kel AND pk.status='A' AND c.id='".$r['id_kecamatan']."' and k.lokasi=c.id and k.desa=d.id order by d.id asc"); 



while($row=mysql_fetch_array($view)){
	$arr[] = $row['nama_desa']." | ".$row['nama_kelompok'];
} 

die(json_encode($arr));
?>