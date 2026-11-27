<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/terbilang.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);

$nominal	= $_POST['cari'];
$terbilang=toTerbilang($nominal);

echo "<strong>Rp. ".number_format($nominal)."</strong> <br>(".ucwords($terbilang)." Rupiah)";

?>