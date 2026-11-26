<?php session_start();
include "../../inc/inc.koneksi.php";

$table_anggota="anggota_1";
$table_pa="pinjaman_anggota_1";
$table_sa="simpanan_anggota_1";	

	$jum_ver_3=mysql_num_rows(mysql_query("select * from $table_anggota a, $table_pa pa WHERE a.id=pa.nia AND a.desa='$_SESSION[lokasi]' AND pa.status='V3' "));

		
	echo "$jum_ver_3";

?>