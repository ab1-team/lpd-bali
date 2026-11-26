<?php session_start();
include "../../inc/inc.koneksi.php";


$data1	=mysql_fetch_array(mysql_query("SELECT sum(ra_$_SESSION[tahun_anggaran]) as sum_rb FROM jenis_akun a, rekening_$_SESSION[lokasi] r WHERE a.id=r.id_akun AND a.posisi='5' "));
$sum_rb	=$data1['sum_rb'];

echo number_format($sum_rb);


?>