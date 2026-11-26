<?php session_start();
include "../../inc/inc.koneksi.php";

$table_anggota="anggota_1";
$table_pa="pinjaman_anggota_1";
$table_sa="simpanan_anggota_1";	

	$jum_kreditur=mysql_num_rows(mysql_query("select * from $table_anggota a, $table_sa sa WHERE a.id=sa.nia AND a.desa='$_SESSION[lokasi]' AND sa.status='A' ")); //Penabung

		
	echo number_format($jum_kreditur,0,',','.');

?>