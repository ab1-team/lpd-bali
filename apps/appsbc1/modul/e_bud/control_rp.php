<?php session_start();
include "../../inc/inc.koneksi.php";


$rp	=mysql_fetch_array(mysql_query("SELECT sum(ra_$_SESSION[tahun_anggaran]) as sum_rp FROM jenis_akun a, rekening_$_SESSION[lokasi] r WHERE a.id=r.id_akun AND a.posisi='4' "));
$sum_rp	=$rp['sum_rp'];

echo number_format($sum_rp);


?>