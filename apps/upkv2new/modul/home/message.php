<?php
sleep(1);
    session_start();
    include "inc/inc.koneksi.php";
    include "inc/fungsi_indotgl.php";
    include "inc/fungsi_keuangan.php";
    include "inc/fungsi_pinjaman.php";

//NOTIVIKASI INVOICE 
	$inv = mysql_query("select * from admin_invoice WHERE status='UNPAID' AND lokasi='$_SESSION[lokasi]' "); 
	$jumpaid = mysql_num_rows($inv);
	if($jumpaid > 0 AND $_SESSION['level'] == "1"){
		$kc = mysql_fetch_array(mysql_query("SELECT * FROM kecamatan where id='$_SESSION[lokasi]' "));
		$rows = mysql_fetch_array(mysql_query("select * from admin_invoice WHERE status='UNPAID' AND lokasi='$_SESSION[lokasi]' "));
		
		//INVOICE
		function sumBayar($idv) { //Jumlah Bayar
					$table_transaksi = "admin_transaksi";
					$row             = mysql_fetch_array(mysql_query("select *, sum(jumlah) as sumjumlah FROM $table_transaksi WHERE idv='$idv' ")); //Deklarasi Jumlah Pembayaran Sebelumnya
					$sumBayar		 = $row['sumjumlah'];

					return $sumBayar;
		}

		function sumTagihan($idv) { //Jumlah Tagihan
					$tag     = mysql_fetch_array(mysql_query("select * FROM admin_invoice WHERE idv='$idv' ")); //Deklarasi Jumlah Tagihan
					$tagihan = $tag['jumlah'];

					return $tagihan;
		}

		function sumSaldo($idv) { //Jumlah Saldo
					$sumBayar = sumBayar($idv);
					$tagihan  = sumTagihan($idv);
					$saldo    = $tagihan-$sumBayar;

					return $saldo;
		}

		while($row=mysql_fetch_array($inv)) {
			$Saldo    = sumSaldo($row['idv']);
			$sumSaldo = $sumSaldo+$Saldo;
		}
		?>
	<div class="alert alert-danger alert-sm">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<span class="fw-semi-bold"><?php echo "$kc[nama_lembaga_sort] $kc[nama_kec]"; ?></span>  yang Terhormat, Anda memiliki <?php echo $jumpaid; ?> tagihan 
		yang belum dibayar senilai Rp. <?php echo number_format($sumSaldo); ?>, silahkan segera lakukan pembayaran.
		<a class="btn btn-default btn-xs pull-right mr" href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/<?php echo hash("sha512",'bismillahirohmanirrokhim'); ?>/INVOICE.php?idv=<?php echo $rows['idv'];?>' )" >Cetak</a>
		<a class="btn btn-danger btn-xs pull-right mr-xs" href="?p=invoice">Lihat Invoice</a>
	</div>
<?php 
}
?>	