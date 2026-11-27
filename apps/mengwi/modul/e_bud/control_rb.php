<?php session_start();
include "../../inc/inc.koneksi.php";


$data1	=mysql_fetch_array(mysql_query("SELECT sum(ra_$_SESSION[tahun_anggaran]) as sum_rb FROM rekening_$_SESSION[lokasi] WHERE posisi='2' AND jenis_mutasi='debit' "));
$sum_rb	=$data1['sum_rb'];

echo number_format($sum_rb);


?>