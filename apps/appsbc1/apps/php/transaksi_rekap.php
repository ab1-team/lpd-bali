<?php session_start();
include "../../inc/inc.koneksi.php";
$table_transaksi="transaksi_".$_SESSION['lokasi'];

$tanggal =date('Y-m-d');
		
		$u=mysql_fetch_array(mysql_query("SELECT namadepan, namabelakang FROM users WHERE id='$_SESSION[id]' "));
		$deb=mysql_fetch_array(mysql_query("SELECT sum(jumlah) as sumdebit FROM $table_transaksi WHERE id_user='$_SESSION[id]' AND tgl_transaksi='$tanggal' AND rekening_debit='1-10001' "));
		$kre=mysql_fetch_array(mysql_query("SELECT sum(jumlah) as sumkredit FROM $table_transaksi WHERE id_user='$_SESSION[id]' AND tgl_transaksi='$tanggal' AND rekening_kredit='1-10001' "));
		
	
	echo '
	<h1 class="text-center mt-4"><i class="fa fa-3x fa-check-circle color-green1-dark"></i></h1>
        <h3 class="text-center mt-3 text-uppercase font-700"> Rekap Transaksi</div></h3>
        <p class="boxed-text-l">
             <div class="row ml-2 mt-2">
                        <div class="col-5">
							Tanggal<br>
							Nama User<br>
							Total Debit<br>
							Total Kredit<br>
							Cash on Hand<br>
                        </div>
                        <div class="col-7">
							: <b>'.$tanggal.'</b><br>
							: <b>'.$u['namadepan'].' '.$u['namabelakang'].'</b><br>
							: <b>Rp. '.number_format($deb['sumdebit'],0,',','.').'</b><br>
							: <b>Rp. '.number_format($kre['sumkredit'],0,',','.').'</b><br>
							: <b>Rp. '.number_format($deb['sumdebit']-$kre['sumkredit'],0,',','.').'</b><br>
						</div>
                    </div>
        </p>
        <a href="#" class="close-menu btn btn-m btn-center-m button-s shadow-l rounded-s text-uppercase font-900 bg-green1-light">Ok</a>
	';
	




?>