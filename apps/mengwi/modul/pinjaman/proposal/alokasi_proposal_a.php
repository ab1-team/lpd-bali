<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/terbilang.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);

$alokasi_anggota	= $_POST['alokasi_anggota'];
$terbilang_alok=toTerbilang($alokasi_anggota);

echo "<strong>Rp. ".number_format($alokasi_anggota)."</strong>";
echo " (".ucwords($terbilang_alok)." Rupiah)";

?>