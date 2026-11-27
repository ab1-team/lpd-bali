<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/terbilang.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);

$pinj_a	=mysql_fetch_array(mysql_query("SELECT *, sum(alokasi) as sumalokangg FROM pinjaman_anggota_$_SESSION[kd_kab] WHERE id_pinkel='$_SESSION[idpinj]' "));
$sumalokangg=$pinj_a['sumalokangg'];

echo number_format($sumalokangg);

?>