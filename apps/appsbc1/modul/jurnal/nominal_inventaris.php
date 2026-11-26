<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";

ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);

$nominal	= $_POST['cari'];

echo "<strong>Rp. ".number_format($nominal)."</strong>";

?>