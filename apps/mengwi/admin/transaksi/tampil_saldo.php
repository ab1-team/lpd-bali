<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_keuangan_admin.php";


$jenis_buku	= $_SESSION['jenis_buku'];
$tgl=date('Y-m-d');
$saldo_buku	=saldo("$tgl-$jenis_buku");

if($saldo_buku>0) {
$ketsaldo="Saldo Debet";
}elseif($saldo_buku<0){
$ketsaldo="Saldo Kredit";
}

?>

<h1 class="page-title pull-right text-muted"><?php echo $ketsaldo;?> : <span class="fw-semi-bold"><?php echo number_format($saldo_buku);?></span></h1>
			