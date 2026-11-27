<?php session_start();
include "../../inc/inc.koneksi.php";


$rp	=mysql_fetch_array(mysql_query("SELECT sum(ra_$_SESSION[tahun_anggaran]) as sum_rp FROM rekening_$_SESSION[lokasi] WHERE posisi='2' AND jenis_mutasi='kredit' "));
$sum_rp	=$rp['sum_rp'];

echo number_format($sum_rp);


?>