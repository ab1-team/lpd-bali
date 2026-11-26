<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_keuangan.php";


$jenis_buku	= $_SESSION['jenis_buku'];
$tgl=date('Y-m-d');
$saldo_buku	=saldo("$tgl-$jenis_buku");

$buku=mysql_fetch_array(mysql_query("SELECT * FROM jenis_buku WHERE kd_jb='$jenis_buku' "));

if($saldo_buku>0) {
$ketsaldo="Saldo Debet";
}elseif($saldo_buku<0){
$ketsaldo="Saldo Kredit";
}else{
$ketsaldo="Tidak Ada Saldo";
}

?>
<section class="widget" style="border: 1px solid #5d8fc2;">
	<div class="widget-body">
		<div class="widget-top-overflow windget-padding-md clearfix bg-primary mb">
			<div class="row">
				<div class="col-md-12">
					<span class="h4 fw-bold text-white">
					<span class="fw-normal"><?php echo "$ketsaldo </span>$buku[nama_jb]";?></span>
				</div>
			</div>
		</div>
		<div class="h1 fw-semi-bold text-align-right"><?php echo number_format($saldo_buku);?></div>
	</div>
</section>
						